<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('defects', function (Blueprint $table): void {
            $table->dropUnique(['slug']);
            $table->unique(['category_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::table('defects', function (Blueprint $table): void {
            $table->dropUnique(['category_id', 'slug']);
            $table->unique('slug');
        });
    }
};
