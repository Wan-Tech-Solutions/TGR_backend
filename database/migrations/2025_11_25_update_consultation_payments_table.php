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
        Schema::table('consultation_payments', function (Blueprint $table) {
            // Add reference column if it doesn't exist
            if (!Schema::hasColumn('consultation_payments', 'reference')) {
                $table->string('reference')->nullable()->unique()->after('provider_reference');
            }

            // Add verification_payload if it doesn't exist
            if (!Schema::hasColumn('consultation_payments', 'verification_payload')) {
                $table->json('verification_payload')->nullable()->after('initialize_payload');
            }

            // Add paid_at if it doesn't exist
            if (!Schema::hasColumn('consultation_payments', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultation_payments', function (Blueprint $table) {
            if (Schema::hasColumn('consultation_payments', 'reference')) {
                $table->dropColumn('reference');
            }
            if (Schema::hasColumn('consultation_payments', 'verification_payload')) {
                $table->dropColumn('verification_payload');
            }
            if (Schema::hasColumn('consultation_payments', 'paid_at')) {
                $table->dropColumn('paid_at');
            }
        });
    }
};
