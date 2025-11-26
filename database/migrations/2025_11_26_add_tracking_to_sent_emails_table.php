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
        Schema::table('sent_emails', function (Blueprint $table) {
            // Add tracking columns if they don't exist
            if (!Schema::hasColumn('sent_emails', 'sender_id')) {
                $table->foreignId('sender_id')->nullable()->constrained('users')->onDelete('set null')->after('uuid');
            }
            if (!Schema::hasColumn('sent_emails', 'status')) {
                $table->enum('status', ['sent', 'pending', 'failed'])->default('pending')->after('attachment');
            }
            if (!Schema::hasColumn('sent_emails', 'recipient_name')) {
                $table->string('recipient_name')->nullable()->after('recipient_email');
            }
            if (!Schema::hasColumn('sent_emails', 'cc')) {
                $table->string('cc')->nullable()->after('recipient_name');
            }
            if (!Schema::hasColumn('sent_emails', 'bcc')) {
                $table->string('bcc')->nullable()->after('cc');
            }
            if (!Schema::hasColumn('sent_emails', 'error_message')) {
                $table->text('error_message')->nullable()->after('status');
            }
            if (!Schema::hasColumn('sent_emails', 'sent_at')) {
                $table->timestamp('sent_at')->nullable()->after('error_message');
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
        Schema::table('sent_emails', function (Blueprint $table) {
            $table->dropForeignKeyIfExists('sent_emails_sender_id_foreign');
            $table->dropColumn([
                'sender_id',
                'status',
                'recipient_name',
                'cc',
                'bcc',
                'error_message',
                'sent_at',
            ]);
        });
    }
};
