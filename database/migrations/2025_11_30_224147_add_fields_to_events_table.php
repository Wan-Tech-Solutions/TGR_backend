<?php

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
        Schema::table('events', function (Blueprint $table) {
            $table->text('description')->nullable()->after('event_title');
            $table->string('location')->nullable()->after('description');
            $table->string('attachment')->nullable()->after('location');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('status');
            $table->string('color', 7)->default('#d93025')->after('priority');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['description', 'location', 'attachment', 'priority', 'color']);
        });
    }
};
