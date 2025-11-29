<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prospectus;

class ProspectusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if a published prospectus already exists
        $exists = Prospectus::where('is_published', true)->exists();
        
        if (!$exists) {
            Prospectus::create([
                'prospectus_title' => 'TGR Investors Community Prospectus',
                'prospectus_file' => '1764241976_Roster_Display_-_GHQ(OPS).pdf',
                'prospectus_description' => 'This is the official prospectus for The Great Return Africa Investors Community',
                'is_published' => true,
            ]);
            
            echo "✓ Created sample prospectus\n";
        } else {
            echo "✓ Published prospectus already exists\n";
        }
    }
}
