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
        Schema::table('prospectus', function (Blueprint $table) {
            $table->string('prospectus_title')->nullable()->after('prospectus');
            $table->string('prospectus_file')->nullable()->after('prospectus_title');
            $table->text('prospectus_description')->nullable()->after('prospectus_file');
            $table->boolean('is_published')->default(true)->after('prospectus_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prospectus', function (Blueprint $table) {
            $table->dropColumn(['prospectus_title', 'prospectus_file', 'prospectus_description', 'is_published']);
        });
    }
};
