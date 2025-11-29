<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

// Test database
$prospectus = \App\Models\Prospectus::all();
echo "Total prospectus: " . $prospectus->count() . "\n";

foreach ($prospectus as $p) {
    echo "ID: {$p->id}, Title: {$p->prospectus_title}, Published: {$p->is_published}, File: {$p->prospectus_file}\n";
}

echo "\n\nPublished prospectus: ";
$published = \App\Models\Prospectus::where('is_published', true)->latest('created_at')->first();
if ($published) {
    echo "Found - {$published->prospectus_title}\n";
} else {
    echo "None found\n";
}

echo "\nFile in public/prospectus:\n";
$files = glob(public_path('prospectus/*'));
foreach ($files as $file) {
    echo basename($file) . " - " . (file_exists($file) ? "EXISTS" : "NOT FOUND") . "\n";
}
