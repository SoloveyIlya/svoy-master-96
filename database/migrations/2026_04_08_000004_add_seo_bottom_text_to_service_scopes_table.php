<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_scopes', function (Blueprint $table) {
            $table->longText('seo_bottom_text')->nullable()->after('seo_h1');
        });
    }

    public function down(): void
    {
        Schema::table('service_scopes', function (Blueprint $table) {
            $table->dropColumn('seo_bottom_text');
        });
    }
};
