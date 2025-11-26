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
        Schema::create('rebook_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained('consultations')->onDelete('cascade');
            $table->string('email');
            $table->text('subject');
            $table->text('message_preview')->nullable();
            $table->string('status')->default('sent'); // sent, failed, opened
            $table->timestamp('sent_at')->useCurrent();
            $table->timestamp('opened_at')->nullable();
            $table->string('sent_by')->nullable(); // admin name who sent it
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rebook_logs');
    }
};
