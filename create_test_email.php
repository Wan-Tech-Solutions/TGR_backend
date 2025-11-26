<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');

// Create test email
$address = \App\Models\EmailAddress::where('email', 'ojamkwab@gmail.com')->first();

if ($address) {
    \App\Models\IncomingEmail::create([
        'email_address_id' => $address->id,
        'from_email' => 'sender@example.com',
        'from_name' => 'Test Sender',
        'to_email' => $address->email,
        'subject' => 'Test Email - Your New Mailing Address Works!',
        'message' => 'This is a test email to verify your new mailing address is working correctly.',
        'html_message' => '<p>This is a test email to verify your new mailing address is working correctly.</p>',
        'status' => 'inbox',
        'is_read' => false,
        'priority' => 'normal',
        'received_at' => now(),
    ]);
    
    echo "✅ Test email created successfully!\n";
    echo "📧 Address: {$address->email}\n";
    echo "📨 Label: {$address->label}\n";
    echo "\nCheck your inbox to see the email.\n";
} else {
    echo "❌ Email address not found!\n";
}
