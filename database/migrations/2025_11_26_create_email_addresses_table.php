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
        Schema::create('email_addresses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index();
            $table->string('email')->unique()->index();
            $table->string('label')->nullable(); // e.g., "Primary", "Support", "Investors"
            $table->text('description')->nullable();
            $table->string('password')->nullable(); // For IMAP/POP3 connection
            $table->string('host')->nullable(); // IMAP/POP3 host
            $table->integer('port')->nullable(); // IMAP/POP3 port
            $table->string('encryption')->nullable(); // SSL, TLS, none
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('auto_sync')->default(false); // Auto sync emails from this address
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
        });

        // Add to_email_address_id to track which address received the email
        Schema::table('incoming_emails', function (Blueprint $table) {
            if (!Schema::hasColumn('incoming_emails', 'email_address_id')) {
                $table->unsignedBigInteger('email_address_id')->nullable()->after('to_email');
                $table->foreign('email_address_id')->references('id')->on('email_addresses')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incoming_emails', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['email_address_id']);
            $table->dropColumn('email_address_id');
        });

        Schema::dropIfExists('email_addresses');
    }
};
