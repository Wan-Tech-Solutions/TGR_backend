<?php
declare (strict_types = 1);
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
        Schema::create('questionnaire_responses', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('country_of_residence')->nullable();
            $table->string('nationality')->nullable();
            $table->string('contact')->nullable();
            $table->text('responses')->nullable();
            $table->string('scores')->nullable();
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
        Schema::dropIfExists('questionnaire_responses');
    }
};
