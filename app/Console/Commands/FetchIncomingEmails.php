<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\IncomingEmail;
use Webklex\IMAP\Facades\Client as ImapClient;
use Illuminate\Support\Str;

class FetchIncomingEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:fetch-incoming {--limit=50 : Number of emails to fetch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch incoming emails from IMAP server and store in database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->info('Connecting to mail server...');
            
            // Connect to the mail server
            $client = ImapClient::account('default');
            $client->connect();

            $this->info('Connected successfully!');

            // Select inbox
            $inbox = $client->getFolder('INBOX');
            
            $limit = (int) $this->option('limit');
            $this->info("Fetching last {$limit} emails...");

            // Fetch emails
            $messages = $inbox->messages()->all()->limit($limit)->get();
            
            $newCount = 0;
            $skipCount = 0;

            foreach ($messages as $message) {
                try {
                    $messageId = $message->getMessageId();
                    
                    // Skip if already exists
                    if (IncomingEmail::where('message_id', $messageId)->exists()) {
                        $skipCount++;
                        continue;
                    }

                    // Extract email data
                    $from = $message->getFrom()[0] ?? null;
                    $to = $message->getTo()[0] ?? null;
                    
                    IncomingEmail::create([
                        'from_email' => $from ? $from->mail : null,
                        'from_name' => $from ? $from->personal : null,
                        'to_email' => $to ? $to->mail : null,
                        'subject' => $message->getSubject(),
                        'message' => $message->getTextBody(),
                        'html_message' => $message->getHTMLBody(),
                        'status' => 'inbox',
                        'is_read' => false,
                        'is_starred' => false,
                        'message_id' => $messageId,
                        'attachment_count' => $message->getAttachments()->count(),
                        'received_at' => $message->getDate(),
                        'priority' => 'normal',
                    ]);

                    $newCount++;
                    $this->info("Imported: {$message->getSubject()}");
                    
                } catch (\Exception $e) {
                    $this->error("Error importing email: " . $e->getMessage());
                    \Log::error("Email import error: " . $e->getMessage());
                    continue;
                }
            }

            $this->info("✓ Import complete!");
            $this->info("  - New emails: {$newCount}");
            $this->info("  - Skipped (already exists): {$skipCount}");

            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error("Failed to fetch emails: " . $e->getMessage());
            \Log::error("IMAP fetch error: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
