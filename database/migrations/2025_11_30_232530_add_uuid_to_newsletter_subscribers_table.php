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
        Schema::table('newsletter_subscribers', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->nullable();
        });

        // Generate UUIDs for existing records
        DB::table('newsletter_subscribers')->whereNull('uuid')->get()->each(function ($subscriber) {
            DB::table('newsletter_subscribers')
                ->where('id', $subscriber->id)
                ->update(['uuid' => (string) Str::uuid()]);
        });

        // Make uuid required
        Schema::table('newsletter_subscribers', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('newsletter_subscribers', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
