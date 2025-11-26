<?php

namespace Database\Seeders;

use App\Models\IncomingEmail;
use Illuminate\Database\Seeder;

class IncomingEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sampleEmails = [
            [
                'from_email' => 'client1@example.com',
                'from_name' => 'John Smith',
                'to_email' => 'info@tgrafrica.com',
                'subject' => 'Inquiry about consultation services',
                'message' => 'Hi, I am interested in learning more about your consultation services. Can you provide more details?',
                'html_message' => '<p>Hi,</p><p>I am interested in learning more about your consultation services. Can you provide more details?</p>',
                'status' => 'inbox',
                'is_read' => false,
                'priority' => 'normal',
                'received_at' => now()->subHours(2),
            ],
            [
                'from_email' => 'partner@business.com',
                'from_name' => 'Jane Doe',
                'to_email' => 'info@tgrafrica.com',
                'subject' => 'Business Partnership Opportunity',
                'message' => 'We would like to discuss a potential partnership with TGR Africa. Please let us know your availability.',
                'html_message' => '<p>We would like to discuss a potential partnership with TGR Africa. Please let us know your availability.</p>',
                'status' => 'inbox',
                'is_read' => false,
                'priority' => 'high',
                'attachment_count' => 1,
                'received_at' => now()->subHours(5),
            ],
            [
                'from_email' => 'newsletter@mailchimp.com',
                'from_name' => 'Mailchimp Newsletter',
                'to_email' => 'info@tgrafrica.com',
                'subject' => 'Your weekly analytics report',
                'message' => 'Here is your weekly email marketing report...',
                'html_message' => '<p>Here is your weekly email marketing report...</p>',
                'status' => 'inbox',
                'is_read' => true,
                'read_at' => now()->subHours(1),
                'priority' => 'low',
                'received_at' => now()->subDays(1),
            ],
            [
                'from_email' => 'spam@spammer.com',
                'from_name' => 'Unknown Sender',
                'to_email' => 'info@tgrafrica.com',
                'subject' => 'Click here to win free money!!!',
                'message' => 'You have been selected to receive $1,000,000...',
                'status' => 'spam',
                'is_read' => false,
                'priority' => 'low',
                'received_at' => now()->subHours(12),
            ],
        ];

        foreach ($sampleEmails as $email) {
            IncomingEmail::create($email);
        }
    }
}
