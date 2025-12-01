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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // e.g., 'consultation_booked', 'consultation_confirmed', etc.
            $table->string('title');
            $table->text('message');
            $table->string('icon')->nullable(); // Font Awesome icon class
            $table->string('color')->default('info'); // Bootstrap color: primary, success, danger, warning, info
            $table->unsignedBigInteger('notifiable_id');
            $table->string('notifiable_type');
            $table->string('related_type')->nullable(); // e.g., 'Consultation'
            $table->unsignedBigInteger('related_id')->nullable(); // ID of related object
            $table->boolean('read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->index(['notifiable_type', 'notifiable_id']);
            $table->index(['type', 'read']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

