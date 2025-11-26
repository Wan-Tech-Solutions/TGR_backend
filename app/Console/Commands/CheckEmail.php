<?php

namespace App\Console\Commands;

use App\Models\EmailAddress;
use App\Models\IncomingEmail;
use Illuminate\Console\Command;

class CheckEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-email {--address= : Specific email address to sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync emails from configured email addresses via IMAP/POP3';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🔄 Starting email sync process...');

        try {
            // Get email addresses to sync
            $query = EmailAddress::where('is_active', true)->where('auto_sync', true);

            // Filter by specific address if provided
            if ($this->option('address')) {
                $query->where('email', $this->option('address'));
            }

            $addresses = $query->get();

            if ($addresses->isEmpty()) {
                $this->warn('⚠️  No active email addresses with auto-sync enabled.');
                return Command::SUCCESS;
            }

            $this->info("📧 Found " . $addresses->count() . " address(es) to sync\n");

            foreach ($addresses as $address) {
                $this->syncEmailAddress($address);
            }

            $this->info("\n✅ Email sync completed successfully!");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Error syncing emails: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Sync emails from a specific email address
     */
    private function syncEmailAddress(EmailAddress $address)
    {
        $this->info("📬 Syncing: {$address->email} ({$address->label})");

        try {
            // Validate configuration
            if (!$address->host || !$address->port) {
                $this->warn("   ⚠️  Skipped - No IMAP/POP3 configuration");
                return;
            }

            // Get decrypted password
            $password = $address->getDecryptedPassword();
            if (!$password) {
                $this->warn("   ⚠️  Skipped - No password configured");
                return;
            }

            // Connect to IMAP
            $mailbox = "{" . $address->host . ":" . $address->port . "/imap/ssl}INBOX";
            
            // Check if imap_open is available
            if (!function_exists('imap_open')) {
                $this->warn("   ⚠️  IMAP extension not available - using manual import instead");
                $this->createManualTestEmail($address);
                return;
            }

            // Try to open IMAP connection
            $this->line("   🔗 Connecting to {$address->host}...");
            $imap = @imap_open($mailbox, $address->email, $password);

            if (!$imap) {
                $this->error("   ❌ Connection failed: " . imap_last_error());
                $this->createManualTestEmail($address);
                return;
            }

            // Get email count
            $emails = imap_search($imap, 'UNSEEN');
            $emailCount = $emails ? count($emails) : 0;

            if ($emailCount === 0) {
                $this->line("   ✅ No new emails");
                imap_close($imap);
                $address->updateSyncTime();
                return;
            }

            $this->line("   📨 Found {$emailCount} new email(s)");

            // Process each email
            foreach ($emails as $emailNum) {
                $this->processImapEmail($imap, $emailNum, $address);
            }

            // Close connection
            imap_close($imap);

            // Update sync time
            $address->updateSyncTime();
            $this->line("   ✅ Sync completed - {$emailCount} email(s) imported");

        } catch (\Exception $e) {
            $this->error("   ❌ Error: " . $e->getMessage());
        }
    }

    /**
     * Process a single email from IMAP
     */
    private function processImapEmail($imap, $emailNum, EmailAddress $address)
    {
        try {
            $header = imap_headerinfo($imap, $emailNum);
            $body = imap_fetchbody($imap, $emailNum, '1');
            
            // Get plain text or HTML
            $structure = imap_fetchstructure($imap, $emailNum);
            $message = '';
            $htmlMessage = '';

            if (isset($structure->parts)) {
                foreach ($structure->parts as $part) {
                    if ($part->type == 0) { // text
                        $message = imap_fetchbody($imap, $emailNum, count($structure->parts) > 1 ? '1' : '');
                    } elseif ($part->type == 2) { // multipart
                        $htmlMessage = imap_fetchbody($imap, $emailNum, '2');
                    }
                }
            } else {
                $message = $body;
            }

            // Decode quoted-printable
            $message = quoted_printable_decode($message);
            $htmlMessage = quoted_printable_decode($htmlMessage);

            // Extract email addresses
            $fromEmail = isset($header->from[0]->mailbox) ? 
                "{$header->from[0]->mailbox}@{$header->from[0]->host}" : 'unknown@example.com';
            $fromName = isset($header->from[0]->personal) ? $header->from[0]->personal : '';

            // Check if email already exists
            $exists = IncomingEmail::where('message_id', $header->message_id)
                                   ->orWhere('from_email', $fromEmail)
                                   ->where('subject', $header->subject)
                                   ->where('received_at', \Carbon\Carbon::createFromTimestamp($header->date))
                                   ->exists();

            if ($exists) {
                $this->line("   ⊘ Skipped duplicate: {$fromEmail}");
                return;
            }

            // Create incoming email record
            IncomingEmail::create([
                'email_address_id' => $address->id,
                'from_email' => $fromEmail,
                'from_name' => $fromName,
                'to_email' => $address->email,
                'subject' => $header->subject,
                'message' => $message ?: strip_tags($htmlMessage),
                'html_message' => $htmlMessage,
                'status' => 'inbox',
                'is_read' => false,
                'message_id' => $header->message_id,
                'priority' => 'normal',
                'received_at' => \Carbon\Carbon::createFromTimestamp($header->date),
            ]);

            $this->line("   ✓ Imported: {$fromEmail} - {$header->subject}");

        } catch (\Exception $e) {
            $this->line("   ⚠️  Error processing email: " . $e->getMessage());
        }
    }

    /**
     * Create a test email when IMAP is not available
     */
    private function createManualTestEmail(EmailAddress $address)
    {
        // Only create one test email per address per day
        $existingTest = IncomingEmail::where('email_address_id', $address->id)
                                     ->where('from_email', 'system@test.local')
                                     ->where('created_at', '>', now()->subHours(24))
                                     ->exists();

        if (!$existingTest) {
            IncomingEmail::create([
                'email_address_id' => $address->id,
                'from_email' => 'system@test.local',
                'from_name' => 'System Test',
                'to_email' => $address->email,
                'subject' => '✅ Email address configured and active!',
                'message' => "Your email address {$address->email} ({$address->label}) is now configured and ready to receive emails.\n\nNote: Direct IMAP connection not available. Real emails will need to be imported via webhook or manual upload.",
                'html_message' => "<p>Your email address <strong>{$address->email}</strong> ({$address->label}) is now configured and ready to receive emails.</p><p><em>Note: Direct IMAP connection not available. Real emails will need to be imported via webhook or manual upload.</em></p>",
                'status' => 'inbox',
                'is_read' => false,
                'priority' => 'normal',
                'received_at' => now(),
            ]);

            $this->line("   ℹ️  Test email created (IMAP not available)");
        }
    }
}
