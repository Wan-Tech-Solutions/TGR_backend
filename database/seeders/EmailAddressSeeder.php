<?php

namespace Database\Seeders;

use App\Models\EmailAddress;
use Illuminate\Database\Seeder;

class EmailAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emailAddresses = [
            [
                'email' => 'info@tgrafrica.com',
                'label' => 'Primary',
                'description' => 'Main company email address for general inquiries',
                'is_active' => true,
                'auto_sync' => true,
                'host' => 'imap.gmail.com',
                'port' => 993,
                'encryption' => 'ssl',
            ],
            [
                'email' => 'investorscommunity@tgrafrica.com',
                'label' => 'Investors',
                'description' => 'Email address for investor-related communications',
                'is_active' => true,
                'auto_sync' => true,
                'host' => 'imap.gmail.com',
                'port' => 993,
                'encryption' => 'ssl',
            ],
            [
                'email' => 'support@tgrafrica.com',
                'label' => 'Support',
                'description' => 'Customer support email address',
                'is_active' => false,
                'auto_sync' => false,
                'host' => null,
                'port' => null,
                'encryption' => null,
            ],
            [
                'email' => 'noreply@tgrafrica.com',
                'label' => 'No Reply',
                'description' => 'Automated email address for system notifications',
                'is_active' => false,
                'auto_sync' => false,
                'host' => null,
                'port' => null,
                'encryption' => null,
            ],
        ];

        foreach ($emailAddresses as $address) {
            EmailAddress::firstOrCreate(
                ['email' => $address['email']],
                $address
            );
        }
    }
}
