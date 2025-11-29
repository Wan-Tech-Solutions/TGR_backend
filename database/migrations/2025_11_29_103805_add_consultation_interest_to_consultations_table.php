<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            // Add consultation_interest if it doesn't exist
            if (!Schema::hasColumn('consultations', 'consultation_interest')) {
                $table->text('consultation_interest')->nullable()->after('consultation_hours');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            if (Schema::hasColumn('consultations', 'consultation_interest')) {
                $table->dropColumn('consultation_interest');
            }
        });
    }
};
