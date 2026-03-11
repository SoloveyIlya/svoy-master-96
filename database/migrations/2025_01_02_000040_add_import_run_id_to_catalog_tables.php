<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('device_models', function (Blueprint $table) {
            $table->unsignedBigInteger('import_run_id')->nullable()->after('noindex');
        });

        Schema::table('landing_pages', function (Blueprint $table) {
            $table->unsignedBigInteger('import_run_id')->nullable()->after('noindex');
        });
    }

    public function down(): void
    {
        Schema::table('device_models', function (Blueprint $table) {
            $table->dropColumn('import_run_id');
        });

        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn('import_run_id');
        });
    }
};
