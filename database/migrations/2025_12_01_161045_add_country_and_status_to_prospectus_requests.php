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
        Schema::table('prospectus_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('prospectus_requests', 'country')) {
                $table->string('country')->nullable()->after('email');
            }
            if (!Schema::hasColumn('prospectus_requests', 'status')) {
                $table->string('status')->default('pending')->after('country');
            }
            if (!Schema::hasColumn('prospectus_requests', 'downloaded_at')) {
                $table->timestamp('downloaded_at')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prospectus_requests', function (Blueprint $table) {
            if (Schema::hasColumn('prospectus_requests', 'country')) {
                $table->dropColumn('country');
            }
            if (Schema::hasColumn('prospectus_requests', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('prospectus_requests', 'downloaded_at')) {
                $table->dropColumn('downloaded_at');
            }
        });
    }
};
