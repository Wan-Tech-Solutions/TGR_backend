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
        Schema::create('tgr_analytics', function (Blueprint $table) {
            $table->id();
             $table->uuid()->index();
             $table->string('title')->nullable();
             $table->mediumText('first_para_analytic')->nullable();
            $table->mediumText('second_para_analytic')->nullable();
            $table->mediumText('aim_by')->nullable();
            $table->mediumText('analytic_process')->nullable();
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
        Schema::dropIfExists('tgr_analytics');
    }
};
