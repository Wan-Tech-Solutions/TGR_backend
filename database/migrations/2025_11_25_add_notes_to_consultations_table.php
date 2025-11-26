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
            // Add consultation_notes if it doesn't exist
            if (!Schema::hasColumn('consultations', 'consultation_notes')) {
                $table->text('consultation_notes')->nullable()->after('scheduled_for');
            }

            // Add admin_notes if it doesn't exist
            if (!Schema::hasColumn('consultations', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('consultation_notes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            if (Schema::hasColumn('consultations', 'consultation_notes')) {
                $table->dropColumn('consultation_notes');
            }
            if (Schema::hasColumn('consultations', 'admin_notes')) {
                $table->dropColumn('admin_notes');
            }
        });
    }
};
