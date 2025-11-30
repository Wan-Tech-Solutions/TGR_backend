<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        Schema::table('newsletter_subscribers', function (Blueprint $table) {
            $table->string('token', 80)->nullable()->unique()->after('email');
            $table->boolean('active')->default(true)->after('token');
        });

        // Backfill tokens for existing subscribers
        $rows = DB::table('newsletter_subscribers')->whereNull('token')->get();
        foreach ($rows as $row) {
            DB::table('newsletter_subscribers')
                ->where('id', $row->id)
                ->update(['token' => Str::random(40)]);
        }
    }

    public function down()
    {
        Schema::table('newsletter_subscribers', function (Blueprint $table) {
            $table->dropColumn(['token', 'active']);
        });
    }
};
