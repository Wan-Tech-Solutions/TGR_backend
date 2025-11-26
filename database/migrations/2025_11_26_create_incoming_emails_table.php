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
        Schema::create('incoming_emails', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('from_email');
            $table->string('from_name')->nullable();
            $table->string('to_email');
            $table->string('subject');
            $table->longText('message')->nullable();
            $table->longText('html_message')->nullable();
            $table->string('status')->default('inbox')->index(); // inbox, sent, draft, trash, spam
            $table->boolean('is_read')->default(false)->index();
            $table->boolean('is_starred')->default(false)->index();
            $table->string('message_id')->nullable()->unique();
            $table->string('thread_id')->nullable()->index();
            $table->text('cc')->nullable();
            $table->text('bcc')->nullable();
            $table->string('priority')->default('normal'); // low, normal, high
            $table->integer('attachment_count')->default(0);
            $table->timestamp('received_at')->nullable()->index();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Create email attachments table
        Schema::create('email_attachments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('incoming_email_id');
            $table->string('filename');
            $table->string('mime_type');
            $table->unsignedBigInteger('size');
            $table->string('path');
            $table->timestamps();
            $table->foreign('incoming_email_id')->references('id')->on('incoming_emails')->onDelete('cascade');
        });

        // Create email tags table for organization
        Schema::create('email_tags', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('color')->default('#007BFF');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['user_id', 'name']);
        });

        // Pivot table for email tags
        Schema::create('email_tag_mappings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('incoming_email_id');
            $table->unsignedBigInteger('email_tag_id');
            $table->timestamps();
            $table->foreign('incoming_email_id')->references('id')->on('incoming_emails')->onDelete('cascade');
            $table->foreign('email_tag_id')->references('id')->on('email_tags')->onDelete('cascade');
            $table->unique(['incoming_email_id', 'email_tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_tag_mappings');
        Schema::dropIfExists('email_tags');
        Schema::dropIfExists('email_attachments');
        Schema::dropIfExists('incoming_emails');
    }
};
