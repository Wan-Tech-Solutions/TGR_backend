<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Mail\ProspectusMail;

echo "Starting investors mailer test...\n";

try {
    $recipient = 'ojamkwab@gmail.com';
    $pdfUrl = url('prospectus/1764242597_Roster_Display_-_GHQ(OPS).pdf');

    echo "Sending to: $recipient\n";
    Mail::mailer('investors')->to($recipient)->send(new ProspectusMail($recipient, $pdfUrl));

    echo "Mail send attempted without throwing an exception.\n";
} catch (Throwable $e) {
    echo "Exception thrown during send:\n";
    echo $e->getMessage() . "\n";
    echo $e . "\n";
    exit(1);
}

echo "Done. Check storage/logs/laravel.log for full details.\n";
