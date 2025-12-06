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
        Schema::create('event_rsvps', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('email');
            $table->enum('response', ['yes', 'no', 'maybe'])->default('yes');
            $table->text('message')->nullable();
            $table->timestamp('responded_at')->useCurrent();
            $table->timestamps();

            $table->index(['event_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_rsvps');
    }
};
