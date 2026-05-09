<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Приводим все сервисы с slug 'diagnostika' к нейтральному названию 'Диагностика'
        DB::table('services')
            ->where('slug', 'diagnostika')
            ->update([
                'name' => 'Диагностика',
                'seo_h1' => 'Диагностика',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        // no-op
    }
};
