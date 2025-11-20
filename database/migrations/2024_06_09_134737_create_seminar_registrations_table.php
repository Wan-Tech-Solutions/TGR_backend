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
        Schema::create('seminar_registrations', function (Blueprint $table) {
            $table->id();
             $table->uuid()->index();
             $table->string('full_name')->nullable();
             $table->string('email')->nullable();
             $table->string('country_of_residence')->nullable();
             $table->string('nationality')->nullable();
             $table->string('job_category')->nullable();
             $table->string('job_subcategory')->nullable();
             $table->string('subscription_amount')->nullable();
             $table->string('seminar_count')->nullable();
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
        Schema::dropIfExists('seminar_registrations');
    }
};
