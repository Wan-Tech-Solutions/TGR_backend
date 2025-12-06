<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            if (!Schema::hasColumn('visitors', 'country_name')) {
                $table->string('country_name')->nullable()->after('visited_at');
            }
            if (!Schema::hasColumn('visitors', 'country_code')) {
                $table->string('country_code', 8)->nullable()->after('country_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            if (Schema::hasColumn('visitors', 'country_code')) {
                $table->dropColumn('country_code');
            }
            if (Schema::hasColumn('visitors', 'country_name')) {
                $table->dropColumn('country_name');
            }
        });
    }
};
