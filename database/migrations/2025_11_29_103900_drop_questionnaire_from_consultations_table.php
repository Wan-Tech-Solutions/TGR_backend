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
            // Drop questionnaire column if it exists
            if (Schema::hasColumn('consultations', 'questionnaire')) {
                $table->dropColumn('questionnaire');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            // Restore questionnaire column if needed
            if (!Schema::hasColumn('consultations', 'questionnaire')) {
                $table->json('questionnaire')->nullable()->after('country_of_residence');
            }
        });
    }
};
