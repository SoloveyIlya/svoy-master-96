<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Дополняет дефекты для планшетов, ноутбуков и смарт-часов.
     * Для телефонов дефекты уже полные (19 штук), остальные категории были заполнены минимально.
     */
    public function up(): void
    {
        $categories = DB::table('categories')
            ->whereIn('slug', ['remont-planshetov', 'remont-noutbukov', 'remont-smart-chasov'])
            ->get()
            ->keyBy('slug');

        $services = DB::table('services')->get()->keyBy('slug');

        $now = now();

        $newDefects = [

            // ── ПЛАНШЕТЫ: было 2, добавляем 12 с привязкой к услугам ──────────────
            ['name' => 'Разбитое стекло',        'slug' => 'planshet-razbitoe-steklo',         'service' => 'zamena-stekla',          'cat' => 'remont-planshetov'],
            ['name' => 'Не работает экран',       'slug' => 'planshet-ne-rabotaet-ekran',        'service' => 'zamena-ekrana',           'cat' => 'remont-planshetov'],
            ['name' => 'Быстро разряжается',      'slug' => 'planshet-bystro-razryazhaetsya',    'service' => 'zamena-akkumulyatora',    'cat' => 'remont-planshetov'],
            ['name' => 'Не заряжается',           'slug' => 'planshet-ne-zaryazhaetsya',         'service' => 'zamena-razema-zaryadki',  'cat' => 'remont-planshetov'],
            ['name' => 'Попала вода',             'slug' => 'planshet-popala-voda',              'service' => 'remont-posle-zalitiya',   'cat' => 'remont-planshetov'],
            ['name' => 'Разбита задняя крышка',   'slug' => 'planshet-razbita-zadnyaya-kryshka', 'service' => 'zamena-zadnej-kryshki',   'cat' => 'remont-planshetov'],
            ['name' => 'Не работает микрофон',    'slug' => 'planshet-ne-rabotaet-mikrofon',     'service' => 'zamena-mikrofona',        'cat' => 'remont-planshetov'],
            ['name' => 'Не работает динамик',     'slug' => 'planshet-ne-rabotaet-dinamik',      'service' => 'zamena-dinamika',         'cat' => 'remont-planshetov'],
            ['name' => 'Не работает камера',      'slug' => 'planshet-ne-rabotaet-kamera',       'service' => 'zamena-kamery',           'cat' => 'remont-planshetov'],
            ['name' => 'Тормозит / зависает',     'slug' => 'planshet-tormozit',                 'service' => 'proshivka-po',            'cat' => 'remont-planshetov'],
            ['name' => 'Не включается',           'slug' => 'planshet-ne-vklyuchaetsya',         'service' => null,                     'cat' => 'remont-planshetov'],
            ['name' => 'Не работает Wi-Fi',       'slug' => 'planshet-ne-rabotaet-wi-fi',        'service' => null,                     'cat' => 'remont-planshetov'],

            // ── НОУТБУКИ: было 11, добавляем 5 (покрываем оставшиеся услуги) ─────
            ['name' => 'Быстро садится батарея',    'slug' => 'noutbuk-bystro-saditsya-batareya', 'service' => 'zamena-akkumulyatora',    'cat' => 'remont-noutbukov'],
            ['name' => 'Попала вода / залит',        'slug' => 'noutbuk-popala-voda',             'service' => 'remont-posle-zalitiya',   'cat' => 'remont-noutbukov'],
            ['name' => 'Залипают или сломаны клавиши', 'slug' => 'noutbuk-slomany-klavishi',      'service' => 'remont-klavish',          'cat' => 'remont-noutbukov'],
            ['name' => 'Не включается / не стартует', 'slug' => 'noutbuk-ne-vklyuchaetsya',       'service' => 'zamena-materinskoj-platy', 'cat' => 'remont-noutbukov'],
            ['name' => 'Кулер шумит или не крутится', 'slug' => 'noutbuk-kuler-shumit',           'service' => 'zamena-kulera',           'cat' => 'remont-noutbukov'],

            // ── СМАРТ-ЧАСЫ: было 5, добавляем 8 (покрываем оставшиеся услуги) ───
            ['name' => 'Разбитое стекло',          'slug' => 'chasy-razbitoe-steklo',            'service' => 'zamena-stekla',           'cat' => 'remont-smart-chasov'],
            ['name' => 'Не работает экран',         'slug' => 'chasy-ne-rabotaet-ekran',          'service' => 'zamena-ekrana',           'cat' => 'remont-smart-chasov'],
            ['name' => 'Быстро разряжается',        'slug' => 'chasy-bystro-razryazhaetsya',      'service' => 'zamena-akkumulyatora',    'cat' => 'remont-smart-chasov'],
            ['name' => 'Не заряжается',             'slug' => 'chasy-ne-zaryazhaetsya',           'service' => 'zamena-razema-zaryadki',  'cat' => 'remont-smart-chasov'],
            ['name' => 'Попала вода',               'slug' => 'chasy-popala-voda',                'service' => 'remont-posle-zalitiya',   'cat' => 'remont-smart-chasov'],
            ['name' => 'Не работает кнопка',        'slug' => 'chasy-ne-rabotaet-knopka',         'service' => 'zamena-knopki',           'cat' => 'remont-smart-chasov'],
            ['name' => 'Не работает микрофон',      'slug' => 'chasy-ne-rabotaet-mikrofon',       'service' => 'zamena-mikrofona',        'cat' => 'remont-smart-chasov'],
            ['name' => 'Не работает динамик',       'slug' => 'chasy-ne-rabotaet-dinamik',        'service' => 'zamena-dinamika',         'cat' => 'remont-smart-chasov'],
        ];

        foreach ($newDefects as $defect) {
            if (DB::table('defects')->where('slug', $defect['slug'])->exists()) {
                continue;
            }

            $categoryId = $categories[$defect['cat']]->id ?? null;
            $serviceId  = ($defect['service'] && isset($services[$defect['service']]))
                ? $services[$defect['service']]->id
                : null;

            if (! $categoryId) {
                continue;
            }

            DB::table('defects')->insert([
                'name'        => $defect['name'],
                'slug'        => $defect['slug'],
                'description' => $defect['name'],
                'service_id'  => $serviceId,
                'category_id' => $categoryId,
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('defects')->whereIn('slug', [
            // Планшеты
            'planshet-razbitoe-steklo', 'planshet-ne-rabotaet-ekran', 'planshet-bystro-razryazhaetsya',
            'planshet-ne-zaryazhaetsya', 'planshet-popala-voda', 'planshet-razbita-zadnyaya-kryshka',
            'planshet-ne-rabotaet-mikrofon', 'planshet-ne-rabotaet-dinamik', 'planshet-ne-rabotaet-kamera',
            'planshet-tormozit', 'planshet-ne-vklyuchaetsya', 'planshet-ne-rabotaet-wi-fi',
            // Ноутбуки
            'noutbuk-bystro-saditsya-batareya', 'noutbuk-popala-voda', 'noutbuk-slomany-klavishi',
            'noutbuk-ne-vklyuchaetsya', 'noutbuk-kuler-shumit',
            // Смарт-часы
            'chasy-razbitoe-steklo', 'chasy-ne-rabotaet-ekran', 'chasy-bystro-razryazhaetsya',
            'chasy-ne-zaryazhaetsya', 'chasy-popala-voda', 'chasy-ne-rabotaet-knopka',
            'chasy-ne-rabotaet-mikrofon', 'chasy-ne-rabotaet-dinamik',
        ])->delete();
    }
};
