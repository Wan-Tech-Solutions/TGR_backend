<?php
declare(strict_types=1);
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultations', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('consultations', 'name')) {
                $table->string('name')->nullable();
            }
            if (!Schema::hasColumn('consultations', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('consultations', 'dial_code')) {
                $table->string('dial_code')->nullable();
            }
            if (!Schema::hasColumn('consultations', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('consultations', 'nationality')) {
                $table->string('nationality')->nullable();
            }
            if (!Schema::hasColumn('consultations', 'country_of_residence')) {
                $table->string('country_of_residence')->nullable();
            }
            if (!Schema::hasColumn('consultations', 'questionnaire')) {
                $table->json('questionnaire')->nullable();
            }
            if (!Schema::hasColumn('consultations', 'consultation_hours')) {
                $table->integer('consultation_hours')->nullable();
            }
            if (!Schema::hasColumn('consultations', 'scheduled_for')) {
                $table->date('scheduled_for')->nullable();
            }
            if (!Schema::hasColumn('consultations', 'quoted_amount')) {
                $table->integer('quoted_amount')->nullable();
            }
            if (!Schema::hasColumn('consultations', 'status')) {
                $table->string('status')->default('pending');
            }
            if (!Schema::hasColumn('consultations', 'payment_status')) {
                $table->string('payment_status')->default('pending');
            }
            if (!Schema::hasColumn('consultations', 'payment_reference')) {
                $table->string('payment_reference')->nullable();
            }
            if (!Schema::hasColumn('consultations', 'meta')) {
                $table->json('meta')->nullable();
            }
            if (!Schema::hasColumn('consultations', 'rebook_parent_id')) {
                $table->unsignedBigInteger('rebook_parent_id')->nullable();
            }
            if (!Schema::hasColumn('consultations', 'rebook_count')) {
                $table->integer('rebook_count')->default(0);
            }
            
            // Add indexes
            if (!Schema::hasIndex('consultations', 'consultations_email_index')) {
                $table->index('email');
            }
            if (!Schema::hasIndex('consultations', 'consultations_scheduled_for_index')) {
                $table->index('scheduled_for');
            }
            if (!Schema::hasIndex('consultations', 'consultations_status_index')) {
                $table->index('status');
            }
            if (!Schema::hasIndex('consultations', 'consultations_payment_status_index')) {
                $table->index('payment_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropIndexIfExists('consultations_email_index');
            $table->dropIndexIfExists('consultations_scheduled_for_index');
            $table->dropIndexIfExists('consultations_status_index');
            $table->dropIndexIfExists('consultations_payment_status_index');
        });
    }
};
