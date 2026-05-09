<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // Очищаем префиксы категорий в slug'ах услуг вида {categorySlug}-{serviceSlug}
        $services = DB::table('services')->get();

        foreach ($services as $s) {
            $categorySlugs = DB::table('category_service')
                ->join('categories', 'category_service.category_id', '=', 'categories.id')
                ->where('category_service.service_id', $s->id)
                ->pluck('categories.slug')
                ->toArray();

            foreach ($categorySlugs as $catSlug) {
                $prefix = $catSlug . '-';
                if (Str::startsWith($s->slug, $prefix)) {
                    $candidate = substr($s->slug, strlen($prefix));
                    if (empty($candidate)) {
                        continue;
                    }

                    // Обеспечим уникальность
                    $exists = DB::table('services')->where('slug', $candidate)->where('id', '!=', $s->id)->exists();
                    if ($exists) {
                        $candidate = $candidate . '-' . $s->id;
                        $i = 1;
                        while (DB::table('services')->where('slug', $candidate)->where('id', '!=', $s->id)->exists()) {
                            $candidate = substr($candidate, 0, 200) . '-' . $i;
                            $i++;
                        }
                    }

                    DB::table('services')->where('id', $s->id)->update(['slug' => $candidate]);
                    break;
                }
            }
        }
    }

    public function down(): void
    {
        // no-op: изменения неперезаписываемы автоматически
    }
};
