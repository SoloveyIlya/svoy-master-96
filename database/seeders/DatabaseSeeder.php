<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\BrandCategorySeoText;
use App\Models\Category;
use App\Models\Defect;
use App\Models\DeviceModel;
use App\Models\LandingPage;
use App\Models\Lead;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceScope;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Отключаем логирование запросов для ускорения сидера
        DB::disableQueryLog();

        // ─── 0. Очистка каталожных таблиц ───
        $this->command->info('Очищаем каталожные таблицы...');
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        BrandCategorySeoText::truncate();
        LandingPage::truncate();
        ServiceScope::truncate();
        DeviceModel::truncate();
        Defect::truncate();
        Brand::truncate();
        Service::truncate();
        Category::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // ─── 1. Admin ───
        User::updateOrCreate(
            ['email' => 'admin@svoymaster.ru'],
            ['name' => 'Admin', 'password' => bcrypt('AdmSM2025!@#')]
        );

        // ═══════════════════════════════════════════════════════════
        // 2. БАЗОВЫЕ УСЛУГИ (с привязкой к категориям через 'cats')
        // ═══════════════════════════════════════════════════════════
        $this->command->info('Создаем базовые услуги (Services)...');

        $priceMap = [
            'remont-telefonov' => [
                'diagnostika' => 0,
                'zamena-ekrana' => 1500,
                'zamena-stekla' => 2500,
                'zamena-akkumulyatora' => 900,
                'zamena-razema-zaryadki' => 1200,
                'zamena-dinamika' => 800,
                'zamena-mikrofona' => 1000,
                'zamena-kamery' => 1500,
                'zamena-knopki' => 1000,
                'remont-posle-zalitiya' => 1500,
                'proshivka-po' => 1000,
                'razblokirovka' => 1000,
                'remont-platy' => 2500,
                'zamena-zadnej-kryshki' => 1000,
                'zamena-stekla-kamery' => 800,
                'vyezd-mastera' => 0,
            ],
            'remont-planshetov' => [
                'diagnostika' => 0,
                'zamena-stekla' => 2500,
                'zamena-ekrana' => 2000,
                'zamena-akkumulyatora' => 1500,
                'zamena-razema-zaryadki' => 1500,
                'zamena-knopki' => 1200,
                'remont-platy' => 2500, // Восстановление цепей питания
                'zamena-zadnej-kryshki' => 1500,
                'zamena-korpusa' => 1500,
                'remont-posle-zalitiya' => 2000,
                'zamena-kamery' => 1500,
            ],
            'remont-noutbukov' => [
                'diagnostika' => 0,
                'chistka-ot-pyli' => 1200,
                'zamena-matricy' => 1500,
                'zamena-klaviatury' => 1000,
                'zamena-akkumulyatora' => 1000,
                'zamena-razema-zaryadki' => 1500,
                'remont-posle-zalitiya' => 2500,
                'ustanovka-windows' => 1500,
                'proshivka-po' => 800,
                'zamena-materinskoj-platy' => 3500,
                'zamena-petel' => 2000,
                'zamena-hdd-ssd' => 800,
                'zamena-kulera' => 1000,
                'zamena-tachpada' => 1200,
                'zamena-korpusa' => 2500,
            ],
            'remont-smart-chasov' => [
                'diagnostika' => 0,
                'zamena-stekla' => 4500,
                'zamena-ekrana' => 3000,
                'zamena-akkumulyatora' => 2500,
                'zamena-remeshka' => 1000,
                'zamena-zadnej-kryshki' => 1000,
            ],
            'remont-naushnikov' => [
                'diagnostika' => 0,
                'zamena-akkumulyatora' => 1500,
                'zamena-razema' => 1000,
                'zamena-dinamika' => 1000,
            ],
            'remont-komputerov' => [
                'diagnostika' => 0,
                'zamena-bloka-pitaniya' => 1000,
                'ustanovka-windows' => 1500,
                'chistka-ot-pyli' => 1000,
                'sborka-pk' => 2500,
            ],
            'remont-pristavok' => [
                'diagnostika' => 0,
                'chistka-ot-pyli' => 1500,
                'zamena-termopasty' => 1500,
            ]
        ];

        $servicesData = [
            // Услуги телефонов, планшетов, часов
            ['name'=>'Замена стекла', 'slug'=>'zamena-stekla', 'cats'=>['remont-telefonov', 'remont-planshetov', 'remont-smart-chasov']],
            ['name'=>'Замена экрана (дисплея)', 'slug'=>'zamena-ekrana', 'cats'=>['remont-telefonov', 'remont-planshetov', 'remont-smart-chasov']],
            ['name'=>'Замена аккумулятора', 'slug'=>'zamena-akkumulyatora', 'cats'=>['remont-telefonov', 'remont-planshetov', 'remont-smart-chasov', 'remont-noutbukov']],
            ['name'=>'Замена разъема зарядки', 'slug'=>'zamena-razema-zaryadki', 'cats'=>['remont-telefonov', 'remont-planshetov', 'remont-smart-chasov', 'remont-noutbukov']],
            ['name'=>'Ремонт после залития', 'slug'=>'remont-posle-zalitiya', 'cats'=>['remont-telefonov', 'remont-planshetov', 'remont-smart-chasov', 'remont-noutbukov']],
            ['name'=>'Замена задней крышки', 'slug'=>'zamena-zadnej-kryshki', 'cats'=>['remont-telefonov', 'remont-planshetov', 'remont-smart-chasov']],
            ['name'=>'Замена микрофона', 'slug'=>'zamena-mikrofona', 'cats'=>['remont-telefonov', 'remont-planshetov', 'remont-smart-chasov']],
            ['name'=>'Замена динамика', 'slug'=>'zamena-dinamika', 'cats'=>['remont-telefonov', 'remont-planshetov', 'remont-smart-chasov']],
            ['name'=>'Перепрошивка / Обновление ПО', 'slug'=>'proshivka-po', 'cats'=>['remont-telefonov', 'remont-planshetov', 'remont-smart-chasov']],
            ['name'=>'Разблокировка (удаление пароля)', 'slug'=>'razblokirovka', 'cats'=>['remont-telefonov', 'remont-planshetov', 'remont-smart-chasov']],
            ['name'=>'Замена камеры', 'slug'=>'zamena-kamery', 'cats'=>['remont-telefonov', 'remont-planshetov']],
            ['name'=>'Замена стекла камеры', 'slug'=>'zamena-stekla-kamery', 'cats'=>['remont-telefonov', 'remont-planshetov']],
            ['name'=>'Выезд мастера', 'slug'=>'vyezd-mastera', 'cats'=>['remont-telefonov']],
            ['name'=>'Замена кнопки (цифровой коронки)', 'slug'=>'zamena-knopki', 'cats'=>['remont-smart-chasov']],
            ['name'=>'Замена ремешка (креплений)', 'slug'=>'zamena-remeshka', 'cats'=>['remont-smart-chasov']],
            ['name'=>'Ремонт вибромотора', 'slug'=>'remont-vibromotora', 'cats'=>['remont-smart-chasov']],

            // Услуги Ноутбуков
            ['name'=>'Замена матрицы (экрана)', 'slug'=>'zamena-matricy', 'cats'=>['remont-noutbukov']],
            ['name'=>'Замена клавиатуры', 'slug'=>'zamena-klaviatury', 'cats'=>['remont-noutbukov']],
            ['name'=>'Чистка от пыли и замена термопасты', 'slug'=>'chistka-ot-pyli', 'cats'=>['remont-noutbukov']],
            ['name'=>'Замена жесткого диска (HDD/SSD)', 'slug'=>'zamena-hdd-ssd', 'cats'=>['remont-noutbukov']],
            ['name'=>'Замена клавиш (ремонт клавиатуры)', 'slug'=>'remont-klavish', 'cats'=>['remont-noutbukov']],
            ['name'=>'Замена петель (крышки)', 'slug'=>'zamena-petel', 'cats'=>['remont-noutbukov']],
            ['name'=>'Замена материнской платы', 'slug'=>'zamena-materinskoj-platy', 'cats'=>['remont-noutbukov']],
            ['name'=>'Замена кулера (вентилятора)', 'slug'=>'zamena-kulera', 'cats'=>['remont-noutbukov']],
            ['name'=>'Замена тачпада', 'slug'=>'zamena-tachpada', 'cats'=>['remont-noutbukov']],
            ['name'=>'Установка Windows / ПО', 'slug'=>'ustanovka-windows', 'cats'=>['remont-noutbukov']],
            ['name'=>'Замена корпуса (верхней/нижней крышки)', 'slug'=>'zamena-korpusa', 'cats'=>['remont-noutbukov', 'remont-planshetov', 'remont-smart-chasov']],
        ];

        // Создаём все базовые услуги и храним в ассоц. массиве по slug
        $serviceMap = []; // slug => Service model
        $serviceCats = []; // slug => ['remont-telefonov', ...]

        foreach ($servicesData as $svc) {
            // Ищем минимальную цену среди всех категорий для этой услуги
            $minPrice = 1000;
            $found = false;
            foreach ($priceMap as $catPrices) {
                if (isset($catPrices[$svc['slug']])) {
                    if (!$found || $catPrices[$svc['slug']] < $minPrice) {
                        $minPrice = $catPrices[$svc['slug']];
                        $found = true;
                    }
                }
            }

            $service = Service::create([
                'name'          => $svc['name'],
                'slug'          => $svc['slug'],
                'price_from'    => $minPrice,
                'duration_text' => '30 минут',
                'status'        => 'active',
            ]);
            $serviceMap[$svc['slug']] = $service;
            $serviceCats[$svc['slug']] = $svc['cats'];
        }

        // ═══════════════════════════════════════════════════════════
        // 3. ОСНОВНОЙ КАТАЛОГ (Телефоны, Планшеты, Ноутбуки, Часы)
        // ═══════════════════════════════════════════════════════════
        $this->command->info('Создаем каталог (Категории → Бренды → Модели → Посадочные)...');

        $catalogData = [
            'remont-telefonov' => [
                'name' => 'Телефоны',
                'name_prepositional' => 'телефонах',
                'brands' => [
                    'apple' => ['name' => 'Apple', 'models' => [
                        'iphone-se'=>'iPhone SE','iphone-11'=>'iPhone 11','iphone-11-pro'=>'iPhone 11 Pro','iphone-11-pro-max'=>'iPhone 11 Pro Max','iphone-12'=>'iPhone 12','iphone-12-mini'=>'iPhone 12 mini','iphone-12-pro'=>'iPhone 12 Pro','iphone-12-pro-max'=>'iPhone 12 Pro Max','iphone-13'=>'iPhone 13','iphone-13-mini'=>'iPhone 13 mini','iphone-13-pro'=>'iPhone 13 Pro','iphone-13-pro-max'=>'iPhone 13 Pro Max','iphone-14'=>'iPhone 14','iphone-14-plus'=>'iPhone 14 Plus','iphone-14-pro'=>'iPhone 14 Pro','iphone-14-pro-max'=>'iPhone 14 Pro Max','iphone-15'=>'iPhone 15','iphone-15-plus'=>'iPhone 15 Plus','iphone-15-pro'=>'iPhone 15 Pro','iphone-15-pro-max'=>'iPhone 15 Pro Max','iphone-16e'=>'iPhone 16e','iphone-16'=>'iPhone 16','iphone-16-plus'=>'iPhone 16 Plus','iphone-16-pro'=>'iPhone 16 Pro','iphone-16-pro-max'=>'iPhone 16 Pro Max','iphone-17e'=>'iPhone 17e','iphone-17'=>'iPhone 17','iphone-17-air'=>'iPhone 17 Air','iphone-17-pro'=>'iPhone 17 Pro','iphone-17-pro-max'=>'iPhone 17 Pro Max'
                    ]],
                    'samsung' => ['name' => 'Samsung', 'models' => [
                        'galaxy-a12'=>'Galaxy A12','galaxy-a13'=>'Galaxy A13','galaxy-a14'=>'Galaxy A14','galaxy-a15'=>'Galaxy A15','galaxy-a25'=>'Galaxy A25','galaxy-a35'=>'Galaxy A35','galaxy-a55'=>'Galaxy A55','galaxy-s21'=>'Galaxy S21','galaxy-s21-plus'=>'Galaxy S21 Plus','galaxy-s21-ultra'=>'Galaxy S21 Ultra','galaxy-s22'=>'Galaxy S22','galaxy-s22-plus'=>'Galaxy S22 Plus','galaxy-s22-ultra'=>'Galaxy S22 Ultra','galaxy-s23'=>'Galaxy S23','galaxy-s23-plus'=>'Galaxy S23 Plus','galaxy-s23-ultra'=>'Galaxy S23 Ultra','galaxy-s24'=>'Galaxy S24','galaxy-s24-plus'=>'Galaxy S24 Plus','galaxy-s24-ultra'=>'Galaxy S24 Ultra','galaxy-z-flip4'=>'Galaxy Z Flip4','galaxy-z-flip5'=>'Galaxy Z Flip5','galaxy-z-flip6'=>'Galaxy Z Flip6','galaxy-z-fold4'=>'Galaxy Z Fold4','galaxy-z-fold5'=>'Galaxy Z Fold5','galaxy-z-fold6'=>'Galaxy Z Fold6',
                        'galaxy-s20'=>'Galaxy S20','galaxy-s20-plus'=>'Galaxy S20 Plus','galaxy-s20-ultra'=>'Galaxy S20 Ultra','galaxy-s20-fe'=>'Galaxy S20 FE','galaxy-note-20'=>'Galaxy Note 20','galaxy-note-20-ultra'=>'Galaxy Note 20 Ultra','galaxy-z-flip'=>'Galaxy Z Flip','galaxy-z-fold-2'=>'Galaxy Z Fold 2','galaxy-a21s'=>'Galaxy A21s','galaxy-a31'=>'Galaxy A31','galaxy-a41'=>'Galaxy A41','galaxy-a51'=>'Galaxy A51','galaxy-a71'=>'Galaxy A71','galaxy-a51-5g'=>'Galaxy A51 5G','galaxy-a71-5g'=>'Galaxy A71 5G','galaxy-z-flip-3'=>'Galaxy Z Flip 3','galaxy-z-fold-3'=>'Galaxy Z Fold 3','galaxy-a22-5g'=>'Galaxy A22 5G','galaxy-a32-5g'=>'Galaxy A32 5G','galaxy-a52'=>'Galaxy A52','galaxy-a52-5g'=>'Galaxy A52 5G','galaxy-a52s-5g'=>'Galaxy A52s 5G','galaxy-a72'=>'Galaxy A72','galaxy-s21-fe'=>'Galaxy S21 FE','galaxy-z-flip-4'=>'Galaxy Z Flip 4','galaxy-z-fold-4'=>'Galaxy Z Fold 4','galaxy-a33-5g'=>'Galaxy A33 5G','galaxy-a53-5g'=>'Galaxy A53 5G','galaxy-a73-5g'=>'Galaxy A73 5G','galaxy-s23-fe'=>'Galaxy S23 FE','galaxy-z-flip-5'=>'Galaxy Z Flip 5','galaxy-z-fold-5'=>'Galaxy Z Fold 5','galaxy-a14-5g'=>'Galaxy A14 5G','galaxy-a24'=>'Galaxy A24','galaxy-a34-5g'=>'Galaxy A34 5G','galaxy-a54-5g'=>'Galaxy A54 5G','galaxy-a04s'=>'Galaxy A04s','galaxy-s24-fe'=>'Galaxy S24 FE','galaxy-z-flip-6'=>'Galaxy Z Flip 6','galaxy-z-fold-6'=>'Galaxy Z Fold 6','galaxy-a15-5g'=>'Galaxy A15 5G','galaxy-a25-5g'=>'Galaxy A25 5G','galaxy-a35-5g'=>'Galaxy A35 5G','galaxy-a55-5g'=>'Galaxy A55 5G','galaxy-a16-5g'=>'Galaxy A16 5G','galaxy-s25'=>'Galaxy S25','galaxy-s25-plus'=>'Galaxy S25 Plus','galaxy-s25-ultra'=>'Galaxy S25 Ultra','galaxy-z-flip-7'=>'Galaxy Z Flip 7','galaxy-z-fold-7'=>'Galaxy Z Fold 7','galaxy-a17-5g'=>'Galaxy A17 5G','galaxy-a26-5g'=>'Galaxy A26 5G','galaxy-a36-5g'=>'Galaxy A36 5G','galaxy-a56-5g'=>'Galaxy A56 5G','galaxy-s26'=>'Galaxy S26','galaxy-s26-plus'=>'Galaxy S26 Plus','galaxy-s26-ultra'=>'Galaxy S26 Ultra','galaxy-a37-5g'=>'Galaxy A37 5G','galaxy-a57-5g'=>'Galaxy A57 5G'
                    ]],
                    'xiaomi' => ['name' => 'Xiaomi', 'models' => [
                        'redmi-note-10'=>'Redmi Note 10','redmi-note-10-pro'=>'Redmi Note 10 Pro','redmi-note-11'=>'Redmi Note 11','redmi-note-11-pro'=>'Redmi Note 11 Pro','redmi-note-12'=>'Redmi Note 12','redmi-note-12-pro'=>'Redmi Note 12 Pro','redmi-note-13'=>'Redmi Note 13','redmi-note-13-pro'=>'Redmi Note 13 Pro','redmi-12c'=>'Redmi 12C','redmi-13c'=>'Redmi 13C','poco-x3-pro'=>'Poco X3 Pro','poco-x5-pro'=>'Poco X5 Pro','poco-f5'=>'Poco F5','mi-11'=>'Mi 11','mi-11-lite'=>'Mi 11 Lite','xiaomi-12'=>'Xiaomi 12','xiaomi-12-pro'=>'Xiaomi 12 Pro','xiaomi-13'=>'Xiaomi 13','xiaomi-13-pro'=>'Xiaomi 13 Pro','xiaomi-14'=>'Xiaomi 14','xiaomi-14-ultra'=>'Xiaomi 14 Ultra',
                        'redmi-note-12s'=>'Redmi Note 12S','redmi-note-12-pro-plus'=>'Redmi Note 12 Pro Plus','redmi-note-12-turbo'=>'Redmi Note 12 Turbo','redmi-12'=>'Redmi 12','redmi-13c-5g'=>'Redmi 13C 5G','poco-x5'=>'POCO X5','poco-m5'=>'POCO M5','xiaomi-13-lite'=>'Xiaomi 13 Lite','xiaomi-13-ultra'=>'Xiaomi 13 Ultra','xiaomi-13t'=>'Xiaomi 13T','xiaomi-13t-pro'=>'Xiaomi 13T Pro','xiaomi-civi-3'=>'Xiaomi Civi 3','redmi-note-13-5g'=>'Redmi Note 13 5G','redmi-note-13-pro-plus'=>'Redmi Note 13 Pro Plus','redmi-k70e'=>'Redmi K70E','redmi-k70'=>'Redmi K70','redmi-k70-pro'=>'Redmi K70 Pro','redmi-k70-ultra'=>'Redmi K70 Ultra','redmi-turbo-3'=>'Redmi Turbo 3','poco-x6'=>'POCO X6','poco-x6-pro'=>'POCO X6 Pro','poco-m6'=>'POCO M6','poco-m6-pro'=>'POCO M6 Pro','poco-f6'=>'POCO F6','poco-f6-pro'=>'POCO F6 Pro','redmi-13-4g'=>'Redmi 13 4G','redmi-13-5g'=>'Redmi 13 5G','redmi-a3'=>'Redmi A3','redmi-a3x'=>'Redmi A3x','redmi-13r-5g'=>'Redmi 13R 5G','redmi-note-13r'=>'Redmi Note 13R','redmi-14c'=>'Redmi 14C','redmi-14c-5g'=>'Redmi 14C 5G','redmi-14r-5g'=>'Redmi 14R 5G','redmi-note-14'=>'Redmi Note 14','redmi-note-14-5g'=>'Redmi Note 14 5G','redmi-note-14-pro'=>'Redmi Note 14 Pro','redmi-note-14-pro-plus'=>'Redmi Note 14 Pro Plus','redmi-note-14s'=>'Redmi Note 14S','poco-c75'=>'POCO C75','poco-c75-5g'=>'POCO C75 5G','poco-m6-plus-5g'=>'POCO M6 Plus 5G','poco-m7-pro'=>'POCO M7 Pro','poco-x7'=>'POCO X7','poco-x7-pro'=>'POCO X7 Pro','xiaomi-14-civi'=>'Xiaomi 14 Civi','xiaomi-14t'=>'Xiaomi 14T','xiaomi-14t-pro'=>'Xiaomi 14T Pro','redmi-turbo-4'=>'Redmi Turbo 4','redmi-turbo-4-pro'=>'Redmi Turbo 4 Pro','redmi-note-15r'=>'Redmi Note 15R','redmi-note-15'=>'Redmi Note 15','redmi-note-15-5g'=>'Redmi Note 15 5G','redmi-note-15-pro'=>'Redmi Note 15 Pro','redmi-note-15-pro-plus'=>'Redmi Note 15 Pro Plus','redmi-15c'=>'Redmi 15C','redmi-15c-5g'=>'Redmi 15C 5G','redmi-15-5g'=>'Redmi 15 5G','redmi-a5'=>'Redmi A5','poco-f7'=>'POCO F7','poco-m7-4g'=>'POCO M7 4G','poco-m7-5g'=>'POCO M7 5G','poco-m8'=>'POCO M8','poco-m8-pro'=>'POCO M8 Pro','xiaomi-15'=>'Xiaomi 15','xiaomi-15-ultra'=>'Xiaomi 15 Ultra','xiaomi-15t'=>'Xiaomi 15T','xiaomi-civi-5-pro'=>'Xiaomi Civi 5 Pro','redmi-k80'=>'Redmi K80','redmi-k80-ultra'=>'Redmi K80 Ultra','redmi-k90'=>'Redmi K90','redmi-turbo-5'=>'Redmi Turbo 5','redmi-turbo-5-max'=>'Redmi Turbo 5 Max','xiaomi-17'=>'Xiaomi 17','xiaomi-17-ultra'=>'Xiaomi 17 Ultra','poco-x8'=>'POCO X8','redmi-note-16-5g'=>'Redmi Note 16 5G'
                    ]],
                    'honor' => ['name' => 'Honor', 'models' => [
                        'honor-50'=>'Honor 50','honor-50-lite'=>'Honor 50 Lite','honor-70'=>'Honor 70','honor-80'=>'Honor 80','honor-90'=>'Honor 90','honor-90-lite'=>'Honor 90 Lite','honor-200'=>'Honor 200','honor-200-pro'=>'Honor 200 Pro','honor-magic-5-pro'=>'Honor Magic 5 Pro','honor-magic-6-pro'=>'Honor Magic 6 Pro','honor-x7'=>'Honor X7','honor-x8'=>'Honor X8','honor-x9'=>'Honor X9','honor-x9b'=>'Honor X9b',
                        'honor-300'=>'Honor 300','honor-300-pro'=>'Honor 300 Pro','honor-magic-4-pro'=>'Honor Magic 4 Pro','honor-magic-7-pro'=>'Honor Magic 7 Pro','honor-magic-v2'=>'Honor Magic V2','honor-magic-v3'=>'Honor Magic V3','honor-play-40'=>'Honor Play 40','honor-play-50'=>'Honor Play 50','honor-play-60-plus'=>'Honor Play 60 Plus','honor-70-lite'=>'Honor 70 Lite','honor-80-pro'=>'Honor 80 Pro','honor-x7a'=>'Honor X7a','honor-x7b'=>'Honor X7b','honor-x7c'=>'Honor X7c','honor-x8a'=>'Honor X8a','honor-x8b'=>'Honor X8b','honor-x9-5g'=>'Honor X9 5G','honor-x9a'=>'Honor X9a','honor-x9c'=>'Honor X9c','honor-x40-gt'=>'Honor X40 GT','honor-x50'=>'Honor X50','honor-x50-pro'=>'Honor X50 Pro','honor-x50-gt'=>'Honor X50 GT','honor-x50i'=>'Honor X50i','honor-x60'=>'Honor X60','honor-x60-pro'=>'Honor X60 Pro'
                    ]],
                    'huawei' => ['name' => 'Huawei', 'models' => [
                        'p30'=>'Huawei P30','p30-pro'=>'Huawei P30 Pro','p40'=>'Huawei P40','p40-pro'=>'Huawei P40 Pro','p50'=>'Huawei P50','p50-pro'=>'Huawei P50 Pro','p60'=>'Huawei P60','p60-pro'=>'Huawei P60 Pro','mate-30'=>'Huawei Mate 30','mate-30-pro'=>'Huawei Mate 30 Pro','mate-40-pro'=>'Huawei Mate 40 Pro','mate-50-pro'=>'Huawei Mate 50 Pro','mate-60-pro'=>'Huawei Mate 60 Pro','nova-10'=>'Huawei Nova 10','nova-11'=>'Huawei Nova 11','nova-12'=>'Huawei Nova 12','nova-12-pro'=>'Huawei Nova 12 Pro',
                        'enjoy-60'=>'Huawei Enjoy 60','enjoy-70'=>'Huawei Enjoy 70','enjoy-70x'=>'Huawei Enjoy 70X','nova-10-pro'=>'Huawei nova 10 Pro','nova-11-pro'=>'Huawei nova 11 Pro','nova-12-ultra'=>'Huawei nova 12 Ultra','nova-13'=>'Huawei nova 13','nova-13-pro'=>'Huawei nova 13 Pro','nova-14'=>'Huawei nova 14','nova-14-pro'=>'Huawei nova 14 Pro','nova-15'=>'Huawei nova 15','nova-15-pro'=>'Huawei nova 15 Pro','nova-flip'=>'Huawei nova Flip','mate-60'=>'Huawei Mate 60','mate-60-pro-plus'=>'Huawei Mate 60 Pro Plus','mate-70'=>'Huawei Mate 70','mate-70-pro'=>'Huawei Mate 70 Pro','mate-x5'=>'Huawei Mate X5','mate-x6'=>'Huawei Mate X6','mate-xt'=>'Huawei Mate XT','pocket-2'=>'Huawei Pocket 2','pura-70'=>'Huawei Pura 70','pura-70-pro'=>'Huawei Pura 70 Pro','pura-70-ultra'=>'Huawei Pura 70 Ultra','pura-80'=>'Huawei Pura 80','pura-80-pro'=>'Huawei Pura 80 Pro'
                    ]],
                    'google-pixel' => ['name' => 'Google Pixel', 'models' => [
                        'pixel-6'=>'Pixel 6','pixel-6-pro'=>'Pixel 6 Pro','pixel-7'=>'Pixel 7','pixel-7-pro'=>'Pixel 7 Pro','pixel-8'=>'Pixel 8','pixel-8-pro'=>'Pixel 8 Pro','pixel-9'=>'Pixel 9','pixel-9-pro'=>'Pixel 9 Pro','pixel-9-pro-xl'=>'Pixel 9 Pro XL','pixel-9-pro-fold'=>'Pixel 9 Pro Fold','pixel-10'=>'Pixel 10','pixel-10-pro'=>'Pixel 10 Pro','pixel-10-pro-xl'=>'Pixel 10 Pro XL','pixel-10-pro-fold'=>'Pixel 10 Pro Fold',
                        'pixel-7a'=>'Pixel 7a','pixel-8a'=>'Pixel 8a','pixel-fold'=>'Pixel Fold','pixel-9a'=>'Pixel 9a','pixel-10a'=>'Pixel 10a'
                    ]],
                    // Бренды без моделей
                    'meizu'=>['name'=>'Meizu'],'zte'=>['name'=>'ZTE'],'lenovo'=>['name'=>'Lenovo'],'asus'=>['name'=>'ASUS'],'sony'=>['name'=>'Sony'],'realme'=>['name'=>'realme'],'oppo'=>['name'=>'Oppo'],'vivo'=>['name'=>'Vivo'],'oneplus'=>['name'=>'OnePlus'],'nokia'=>['name'=>'Nokia'],'motorola'=>['name'=>'Motorola'],'lg'=>['name'=>'LG'],'htc'=>['name'=>'HTC'],'tecno'=>['name'=>'Tecno'],'infinix'=>['name'=>'Infinix'],'poco'=>['name'=>'Poco'],'blackview'=>['name'=>'Blackview'],'ulefone'=>['name'=>'Ulefone'],'doogee'=>['name'=>'Doogee'],'cubot'=>['name'=>'Cubot'],'alcatel'=>['name'=>'Alcatel'],'philips'=>['name'=>'Philips'],'fly'=>['name'=>'Fly'],'dexp'=>['name'=>'DEXP'],'bq'=>['name'=>'BQ'],'texet'=>['name'=>'Texet'],'oukitel'=>['name'=>'Oukitel'],'umidigi'=>['name'=>'Umidigi'],'vertu'=>['name'=>'Vertu']
                ]
            ],
            'remont-planshetov' => [
                'name' => 'Планшеты',
                'name_prepositional' => 'планшетах',
                'brands' => [
                    'apple' => ['name' => 'Apple', 'models' => [
                        'ipad-pro-13'=>'iPad Pro 13','ipad-pro-11'=>'iPad Pro 11','ipad-air-13'=>'iPad Air 13','ipad-air-11'=>'iPad Air 11','ipad-air-5'=>'iPad Air 5','ipad-air-4'=>'iPad Air 4','ipad-10'=>'iPad 10','ipad-9'=>'iPad 9','ipad-mini-6'=>'iPad mini 6'
                    ]],
                    'samsung' => ['name' => 'Samsung', 'models' => [
                        'galaxy-tab-s9-ultra'=>'Galaxy Tab S9 Ultra','galaxy-tab-s9-plus'=>'Galaxy Tab S9 Plus','galaxy-tab-s9'=>'Galaxy Tab S9','galaxy-tab-s8-ultra'=>'Galaxy Tab S8 Ultra','galaxy-tab-s8-plus'=>'Galaxy Tab S8 Plus','galaxy-tab-s8'=>'Galaxy Tab S8','galaxy-tab-s7-fe'=>'Galaxy Tab S7 FE','galaxy-tab-a9-plus'=>'Galaxy Tab A9 Plus','galaxy-tab-a9'=>'Galaxy Tab A9','galaxy-tab-a8'=>'Galaxy Tab A8','galaxy-tab-a7-lite'=>'Galaxy Tab A7 Lite'
                    ]],
                    'xiaomi' => ['name' => 'Xiaomi', 'models' => [
                        'pad-6s-pro'=>'Xiaomi Pad 6S Pro','pad-6'=>'Xiaomi Pad 6','pad-5'=>'Xiaomi Pad 5','redmi-pad-pro'=>'Redmi Pad Pro','redmi-pad-se'=>'Redmi Pad SE','redmi-pad'=>'Redmi Pad'
                    ]],
                    'huawei' => ['name' => 'Huawei', 'models' => [
                        'matepad-pro-13-2'=>'Huawei MatePad Pro 13.2','matepad-11-5'=>'Huawei MatePad 11.5','matepad-11'=>'Huawei MatePad 11'
                    ]],
                    'honor' => ['name' => 'Honor', 'models' => [
                        'pad-9'=>'Honor Pad 9','pad-x9'=>'Honor Pad X9','pad-8'=>'Honor Pad 8'
                    ]],
                    'lenovo'=>['name'=>'Lenovo'],'asus'=>['name'=>'ASUS'],'meizu'=>['name'=>'Meizu'],'sony'=>['name'=>'Sony'],'lg'=>['name'=>'LG'],'nokia'=>['name'=>'Nokia'],'realme'=>['name'=>'realme'],'oppo'=>['name'=>'Oppo'],'teclast'=>['name'=>'Teclast'],'blackview'=>['name'=>'Blackview'],'digma'=>['name'=>'Digma'],'prestigio'=>['name'=>'Prestigio'],'irbis'=>['name'=>'Irbis'],'dexp'=>['name'=>'DEXP'],'bq'=>['name'=>'BQ'],'texet'=>['name'=>'Texet'],'amazon-kindle'=>['name'=>'Amazon Kindle'],'microsoft-surface'=>['name'=>'Microsoft Surface']
                ]
            ],
            'remont-noutbukov' => [
                'name' => 'Ноутбуки',
                'name_prepositional' => 'ноутбуках',
                'brands' => [
                    'apple' => ['name' => 'Apple', 'models' => [
                        'macbook-pro-16-m3-max'=>'MacBook Pro 16 M3 Max','macbook-pro-16-m3-pro'=>'MacBook Pro 16 M3 Pro','macbook-pro-16-m3'=>'MacBook Pro 16 M3','macbook-pro-14-m3-max'=>'MacBook Pro 14 M3 Max','macbook-pro-14-m3-pro'=>'MacBook Pro 14 M3 Pro','macbook-pro-14-m3'=>'MacBook Pro 14 M3','macbook-air-15-m3'=>'MacBook Air 15 M3','macbook-air-13-m3'=>'MacBook Air 13 M3','macbook-air-13-m2'=>'MacBook Air 13 M2','macbook-air-13-m1'=>'MacBook Air 13 M1'
                    ]],
                    'asus' => ['name' => 'Asus', 'models' => [
                        'rog-zephyrus-g14-2024'=>'ASUS ROG Zephyrus G14 (2024)','rog-zephyrus-g16-2024'=>'ASUS ROG Zephyrus G16 (2024)','rog-strix-g16-2024'=>'ASUS ROG Strix G16 (2024)','rog-strix-g18-2024'=>'ASUS ROG Strix G18 (2024)','tuf-gaming-f15-2024'=>'ASUS TUF Gaming F15 (2024)','tuf-gaming-a15-2024'=>'ASUS TUF Gaming A15 (2024)','vivobook-16'=>'ASUS Vivobook 16','vivobook-15'=>'ASUS Vivobook 15','zenbook-14-oled'=>'ASUS Zenbook 14 OLED'
                    ]],
                    'hp' => ['name' => 'HP', 'models' => [
                        'omen-transcend-14'=>'HP Omen Transcend 14','omen-16-2024'=>'HP Omen 16 (2024)','victus-16-2024'=>'HP Victus 16 (2024)','victus-15-2024'=>'HP Victus 15 (2024)','pavilion-plus-14'=>'HP Pavilion Plus 14','pavilion-15'=>'HP Pavilion 15','envy-16'=>'HP Envy 16','envy-x360'=>'HP Envy x360'
                    ]],
                    'lenovo' => ['name' => 'Lenovo', 'models' => [
                        'legion-pro-7i-2024'=>'Lenovo Legion Pro 7i (2024)','legion-pro-5i-2024'=>'Lenovo Legion Pro 5i (2024)','legion-slim-5-2024'=>'Lenovo Legion Slim 5 (2024)','loq-15'=>'Lenovo LOQ 15','thinkpad-x1-carbon-gen-12'=>'Lenovo ThinkPad X1 Carbon Gen 12','thinkpad-x1-yoga-gen-8'=>'Lenovo ThinkPad X1 Yoga Gen 8','ideapad-slim-5'=>'Lenovo IdeaPad Slim 5','ideapad-3'=>'Lenovo IdeaPad 3'
                    ]],
                    'acer' => ['name' => 'Acer', 'models' => [
                        'predator-helios-16-2024'=>'Acer Predator Helios 16 (2024)','predator-helios-18-2024'=>'Acer Predator Helios 18 (2024)','nitro-16-2024'=>'Acer Nitro 16 (2024)','nitro-17-2024'=>'Acer Nitro 17 (2024)','aspire-7'=>'Acer Aspire 7','aspire-5'=>'Acer Aspire 5'
                    ]],
                    'dell' => ['name' => 'Dell', 'models' => [
                        'alienware-m18-r2'=>'Dell Alienware m18 R2','alienware-m16-r2'=>'Dell Alienware m16 R2','xps-16-2024'=>'Dell XPS 16 (2024)','xps-14-2024'=>'Dell XPS 14 (2024)','inspiron-16'=>'Dell Inspiron 16','inspiron-15'=>'Dell Inspiron 15'
                    ]],
                    'msi' => ['name' => 'MSI', 'models' => [
                        'titan-18-hx'=>'MSI Titan 18 HX','raider-ge78-hx'=>'MSI Raider GE78 HX','stealth-16'=>'MSI Stealth 16','katana-17'=>'MSI Katana 17','modern-14'=>'MSI Modern 14'
                    ]],
                    'samsung'=>['name'=>'Samsung'],'sony'=>['name'=>'Sony'],'toshiba'=>['name'=>'Toshiba'],'huawei'=>['name'=>'Huawei'],'honor'=>['name'=>'Honor'],'xiaomi'=>['name'=>'Xiaomi'],'gigabyte'=>['name'=>'Gigabyte'],'razer'=>['name'=>'Razer'],'irbis'=>['name'=>'Irbis'],'dexp'=>['name'=>'DEXP'],'digma'=>['name'=>'Digma'],'prestigio'=>['name'=>'Prestigio'],'fujitsu'=>['name'=>'Fujitsu'],'packard-bell'=>['name'=>'Packard Bell'],'emachines'=>['name'=>'eMachines']
                ]
            ],
            'remont-smart-chasov' => [
                'name' => 'Смарт-часы',
                'name_prepositional' => 'смарт-часах',
                'brands' => [
                    'apple' => ['name' => 'Apple', 'models' => [
                        'ultra-2'=>'Apple Watch Ultra 2','ultra'=>'Apple Watch Ultra','series-9'=>'Apple Watch Series 9','series-8'=>'Apple Watch Series 8','series-7'=>'Apple Watch Series 7','se-2022'=>'Apple Watch SE (2022)','se-2020'=>'Apple Watch SE (2020)'
                    ]],
                    'samsung' => ['name' => 'Samsung', 'models' => [
                        'watch-6-classic'=>'Samsung Galaxy Watch 6 Classic','watch-6'=>'Samsung Galaxy Watch 6','watch-5-pro'=>'Samsung Galaxy Watch 5 Pro','watch-5'=>'Samsung Galaxy Watch 5','watch-4-classic'=>'Samsung Galaxy Watch 4 Classic','watch-4'=>'Samsung Galaxy Watch 4'
                    ]],
                    'huawei' => ['name' => 'Huawei', 'models' => [
                        'watch-gt-4'=>'Huawei Watch GT 4','watch-gt-3-pro'=>'Huawei Watch GT 3 Pro','watch-gt-3'=>'Huawei Watch GT 3','watch-4-pro'=>'Huawei Watch 4 Pro','watch-4'=>'Huawei Watch 4'
                    ]],
                    'xiaomi' => ['name' => 'Xiaomi', 'models' => [
                        'watch-s3'=>'Xiaomi Watch S3','watch-s2'=>'Xiaomi Watch S2','watch-2-pro'=>'Xiaomi Watch 2 Pro','redmi-watch-4'=>'Redmi Watch 4','redmi-watch-3'=>'Redmi Watch 3'
                    ]],
                    'amazfit' => ['name' => 'Amazfit', 'models' => [
                        'balance'=>'Amazfit Balance','gtr-4'=>'Amazfit GTR 4','gts-4'=>'Amazfit GTS 4','band-7'=>'Amazfit Band 7'
                    ]],
                    'garmin' => ['name' => 'Garmin', 'models' => [
                        'fenix-7'=>'Garmin Fenix 7','epix-pro'=>'Garmin Epix Pro','venu-3'=>'Garmin Venu 3','forerunner-265'=>'Garmin Forerunner 265'
                    ]],
                    'honor-watch'=>['name'=>'Honor Watch'],'realme-watch'=>['name'=>'Realme Watch']
                ]
            ]
        ];

        DB::beginTransaction();

        try {
            // Собираем услуги, привязанные к каждой категории, для генерации LandingPages
            $servicesByCategory = []; // catSlug => [Service, ...]
            foreach ($serviceCats as $svcSlug => $cats) {
                foreach ($cats as $catSlug) {
                    $servicesByCategory[$catSlug][] = $serviceMap[$svcSlug];
                }
            }

            foreach ($catalogData as $catSlug => $catData) {
                $genitivesMapping = [
                    'Телефоны'   => 'телефонов',
                    'Планшеты'   => 'планшетов',
                    'Ноутбуки'   => 'ноутбуков',
                    'Смарт-часы' => 'смарт-часов',
                ];
                $genitiveName = $genitivesMapping[$catData['name']] ?? mb_strtolower($catData['name']);

                $category = Category::create([
                    'name'              => $catData['name'],
                    'name_prepositional'=> $catData['name_prepositional'] ?? null,
                    'slug'              => $catSlug,
                    'seo_title'         => "Ремонт {$genitiveName} в Екатеринбурге — цены, сроки, гарантия",
                    'seo_h1'            => "Ремонт {$genitiveName}",
                    'status'            => 'active',
                ]);

                $catServices = $servicesByCategory[$catSlug] ?? [];
                
                // Привязываем услуги к категории (сводная таблица category_service)
                foreach ($catServices as $svcObj) {
                    $price = $priceMap[$catSlug][$svcObj->slug] ?? 1000;

                    DB::table('category_service')->insertOrIgnore([
                        'category_id' => $category->id,
                        'service_id'  => $svcObj->id,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);

                    // ServiceScope для уровня КАТЕГОРИИ
                    ServiceScope::create([
                        'scope_type' => 'category',
                        'scope_id'   => $category->id,
                        'service_id' => $svcObj->id,
                        'price_from' => $price,
                        'seo_title'  => "{$svcObj->name} — {$catData['name']} в Екатеринбурге",
                        'seo_h1'     => "{$svcObj->name} — {$catData['name']}",
                    ]);
                }

                foreach ($catData['brands'] as $brandSlug => $brandData) {
                    // Brand::firstOrCreate — потому что один и тот же slug может
                    // встречаться в нескольких категориях (samsung, xiaomi и т.д.)
                    $brand = Brand::firstOrCreate(
                        ['slug' => $brandSlug],
                        [
                            'name'      => $brandData['name'],
                            'seo_title' => "Ремонт {$brandData['name']} в Екатеринбурге",
                            'seo_h1'    => "Ремонт {$brandData['name']}",
                            'status'    => 'active',
                        ]
                    );

                    foreach ($catServices as $svcObj) {
                        $price = $priceMap[$catSlug][$svcObj->slug] ?? 1000;
                        ServiceScope::updateOrCreate(
                            [
                                'scope_type' => 'brand',
                                'scope_id'   => $brand->id,
                                'service_id' => $svcObj->id,
                            ],
                            [
                                'price_from' => $price,
                                'seo_title' => "{$svcObj->name} {$brand->name} в Екатеринбурге — цены, сроки",
                                'seo_h1'    => "{$svcObj->name} {$brand->name}",
                            ]
                        );
                    }

                    // Создаём модели и LandingPages
                    if (isset($brandData['models'])) {
                        foreach ($brandData['models'] as $modelSlug => $modelName) {
                            $model = DeviceModel::create([
                                'brand_id'    => $brand->id,
                                'category_id' => $category->id,
                                'name'        => $modelName,
                                'slug'        => $modelSlug,
                                'seo_title'   => "Ремонт {$modelName} в Екатеринбурге",
                                'seo_h1'      => "Ремонт {$modelName}",
                                'status'      => 'active',
                            ]);

                            // LandingPages = модель × услуги этой категории
                            foreach ($catServices as $svcObj) {
                                $price = $priceMap[$catSlug][$svcObj->slug] ?? 1000;
                                LandingPage::create([
                                    'category_id' => $category->id,
                                    'brand_id'    => $brand->id,
                                    'model_id'    => $model->id,
                                    'service_id'  => $svcObj->id,
                                    'price_from'  => $price,
                                    'slug'        => Str::limit(
                                        $svcObj->slug . '-' . $catSlug . '-' . $brandSlug . '-' . $modelSlug,
                                        255, ''
                                    ),
                                    'status'      => 'active',
                                ]);
                            }
                        }
                    }
                }

                $this->command->info("  ✓ {$catData['name']}: бренды, модели и посадочные созданы");
            }

            DB::commit();
            $this->command->info('Каталог успешно сгенерирован!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Ошибка: ' . $e->getMessage());
            throw $e;
        }

        // ═══════════════════════════════════════════════════════════
        // 4. "ДРУГИЕ УСТРОЙСТВА" (Category + Service + ServiceScope)
        // ═══════════════════════════════════════════════════════════
        $this->command->info('Создаем "Другие устройства" (Categories + Services + ServiceScopes)...');

        $otherDevicesData = [
            'remont-komputerov' => ['name' => 'Ремонт компьютеров', 'name_prepositional' => 'компьютерах', 'services' => [
                'diagnostika'=>'Диагностика компьютера', 'zamena-bloka-pitaniya'=>'Замена блока питания', 'zamena-materinskoj-platy'=>'Замена материнской платы', 'zamena-operativnoj-pamyati'=>'Замена оперативной памяти', 'zamena-videokarty'=>'Замена видеокарты', 'zamena-hdd-ssd'=>'Замена жесткого диска (HDD/SSD)', 'chistka-ot-pyli'=>'Чистка от пыли', 'zamena-termopasty'=>'Замена термопасты', 'ustanovka-windows'=>'Установка Windows', 'vosstanovlenie-dannyh'=>'Восстановление данных', 'sborka-pk' => 'Сборка из комплектующих'
            ]],
            'remont-monitorov' => ['name' => 'Ремонт мониторов', 'name_prepositional' => 'мониторах', 'services' => [
                'diagnostika'=>'Диагностика монитора', 'zamena-matricy'=>'Замена матрицы', 'zamena-bloka-pitaniya'=>'Замена блока питания', 'remont-podsvetki'=>'Ремонт подсветки', 'zamena-shlejfa'=>'Замена шлейфа', 'remont-materinskoj-platy'=>'Ремонт материнской платы'
            ]],
            'remont-monoblokov' => ['name' => 'Ремонт моноблоков', 'name_prepositional' => 'моноблоках', 'services' => [
                'diagnostika'=>'Диагностика моноблока', 'zamena-matricy'=>'Замена матрицы', 'zamena-hdd-ssd'=>'Замена жесткого диска (HDD/SSD)', 'zamena-operativnoj-pamyati'=>'Замена оперативной памяти', 'zamena-bloka-pitaniya'=>'Замена блока питания', 'chistka-ot-pyli'=>'Чистка от пыли'
            ]],
            'remont-televizorov' => ['name' => 'Ремонт телевизоров', 'name_prepositional' => 'телевизорах', 'services' => [
                'diagnostika'=>'Диагностика телевизора', 'zamena-matricy'=>'Замена матрицы', 'remont-bloka-pitaniya'=>'Ремонт блока питания', 'remont-podsvetki'=>'Ремонт подсветки', 'zamena-shlejfa'=>'Замена шлейфа', 'remont-materinskoj-platy'=>'Ремонт материнской платы', 'obnovlenie-proshivki'=>'Обновление прошивки'
            ]],
            'remont-pristavok' => ['name' => 'Ремонт игровых приставок', 'name_prepositional' => 'игровых приставках', 'services' => [
                'diagnostika'=>'Диагностика приставки', 'remont-bloka-pitaniya'=>'Ремонт блока питания', 'zamena-termopasty'=>'Замена термопасты', 'zamena-kulera'=>'Замена кулера (вентилятора)', 'remont-privoda'=>'Ремонт привода (дисковода)', 'pereproshivka'=>'Перепрошивка'
            ]],
            'remont-dzhojstikov' => ['name' => 'Ремонт джойстиков и геймпадов', 'name_prepositional' => 'джойстиках и геймпадах', 'services' => [
                'diagnostika'=>'Диагностика джойстика', 'remont-stika'=>'Ремонт джойстика (стика)', 'remont-drifta'=>'Ремонт кнопок (дрифт)', 'zamena-akkumulyatora'=>'Замена аккумулятора', 'remont-vibromotora'=>'Ремонт вибромотора', 'zamena-razema-zaryadki'=>'Замена разъема зарядки'
            ]],
            'remont-naushnikov' => ['name' => 'Ремонт наушников', 'name_prepositional' => 'наушниках', 'services' => [
                'diagnostika'=>'Диагностика наушников', 'zamena-razema'=>'Замена разъема (штекера)', 'zamena-akkumulyatora'=>'Замена аккумулятора (беспроводные)', 'zamena-dinamika'=>'Замена динамика (драйвера)', 'zamena-ambushyur'=>'Замена амбушюр', 'remont-platy'=>'Ремонт платы управления'
            ]],
            'remont-portativnyh-kolonok' => ['name' => 'Ремонт портативных колонок', 'name_prepositional' => 'портативных колонках', 'services' => [
                'diagnostika'=>'Диагностика колонки', 'zamena-akkumulyatora'=>'Замена аккумулятора', 'zamena-dinamika'=>'Замена динамика', 'zamena-razema-zaryadki'=>'Замена разъема зарядки', 'remont-platy'=>'Ремонт платы управления', 'remont-posle-zalitiya'=>'Ремонт после залития'
            ]],
            'remont-fotoapparatov' => ['name' => 'Ремонт фотоаппаратов', 'name_prepositional' => 'фотоаппаратах', 'services' => [
                'diagnostika'=>'Диагностика фотоаппарата', 'chistka-matricy'=>'Чистка матрицы', 'zamena-zatvora'=>'Замена затвора', 'remont-obektiva'=>'Ремонт объектива', 'zamena-ekrana'=>'Замена дисплея (экрана)', 'zamena-akkumulyatora'=>'Замена аккумулятора'
            ]],
            'remont-obektivov' => ['name' => 'Ремонт объективов', 'name_prepositional' => 'объективах', 'services' => [
                'diagnostika'=>'Диагностика объектива', 'chistka-obektiva'=>'Чистка объектива', 'zamena-shesterenok'=>'Замена шестеренок (фокусировка)', 'remont-stabilizatora'=>'Ремонт стабилизатора', 'zamena-diafragmy'=>'Замена диафрагмы', 'remont-bajoneta'=>'Ремонт байонета (крепления)'
            ]],
            'remont-fotovspyshek' => ['name' => 'Ремонт фотовспышек', 'name_prepositional' => 'фотовспышках', 'services' => [
                'diagnostika'=>'Диагностика фотовспышки', 'zamena-lampy'=>'Замена лампы (ксенон)', 'remont-kondensatora'=>'Ремонт конденсатора', 'zamena-akkumulyatora'=>'Замена аккумулятора'
            ]],
            'remont-elektronnyh-knig' => ['name' => 'Ремонт электронных книг', 'name_prepositional' => 'электронных книгах', 'services' => [
                'diagnostika'=>'Диагностика электронной книги', 'zamena-ekrana'=>'Замена экрана', 'zamena-akkumulyatora'=>'Замена аккумулятора', 'zamena-razema-zaryadki'=>'Замена разъема зарядки', 'obnovlenie-proshivki'=>'Обновление прошивки'
            ]],
            'remont-kvadrokopterov' => ['name' => 'Ремонт квадрокоптеров и дронов', 'name_prepositional' => 'квадрокоптерах и дронах', 'services' => [
                'diagnostika'=>'Диагностика дрона', 'zamena-motora'=>'Замена мотора', 'zamena-lopastej'=>'Замена лопастей (пропеллеров)', 'remont-gps'=>'Ремонт GPS-модуля', 'remont-kamery'=>'Ремонт камеры', 'zamena-akkumulyatora'=>'Замена аккумулятора'
            ]],
            'remont-robotov-pylesosov' => ['name' => 'Ремонт роботов-пылесосов', 'name_prepositional' => 'роботах-пылесосах', 'services' => [
                'diagnostika'=>'Диагностика робота-пылесоса', 'zamena-akkumulyatora'=>'Замена аккумулятора', 'zamena-shhetok'=>'Замена щеток', 'zamena-koles'=>'Замена колес', 'remont-platy'=>'Ремонт платы управления', 'remont-datchikov'=>'Ремонт датчиков'
            ]],
            'remont-terminalov-sbora-dannyh' => ['name' => 'Ремонт терминалов сбора данных', 'name_prepositional' => 'терминалах сбора данных', 'services' => [
                'diagnostika'=>'Диагностика терминала', 'zamena-ekrana'=>'Замена экрана', 'zamena-akkumulyatora'=>'Замена аккумулятора', 'remont-skanera'=>'Ремонт сканера штрихкода', 'zamena-klaviatury'=>'Замена клавиатуры', 'remont-posle-zalitiya'=>'Ремонт после залития'
            ]],
        ];

        foreach ($otherDevicesData as $catSlug => $catData) {
            $genitivesMapping = [
                'Телефоны'                      => 'телефонов',
                'Планшеты'                      => 'планшетов',
                'Ноутбуки'                      => 'ноутбуков',
                'Смарт-часы'                    => 'смарт-часов',
                'Ремонт игровых приставок'      => 'игровых приставок',
                'Ремонт джойстиков и геймпадов' => 'джойстиков и геймпадов',
                'Ремонт наушников'              => 'наушников',
                'Ремонт портативных колонок'    => 'портативных колонок',
                'Ремонт фотоаппаратов'          => 'фотоаппаратов',
                'Ремонт объективов'             => 'объективов',
                'Ремонт фотовспышек'            => 'фотовспышек',
                'Ремонт электронных книг'       => 'электронных книг',
                'Ремонт квадрокоптеров и дронов' => 'квадрокоптеров и дронов',
                'Ремонт роботов-пылесосов'      => 'роботов-пылесосов',
                'Ремонт терминалов сбора данных' => 'терминалов сбора данных',
                'Ремонт мониторов'              => 'мониторов',
                'Ремонт моноблоков'             => 'моноблоков',
                'Ремонт телевизоров'            => 'телевизоров',
                'Ремонт компьютеров'            => 'компьютеров',
            ];

            $categoryName = $catData['name'];
            $genitiveName = $genitivesMapping[$categoryName] ?? mb_strtolower($categoryName);
            
            // Если ключ начинается с "Ремонт", то в genitiveName уже вторая часть.
            // Нам нужно "Ремонт [genitive]"
            $seoString = str_starts_with(mb_strtolower($categoryName), 'ремонт') 
                ? "Ремонт {$genitiveName}" 
                : "Ремонт " . mb_strtolower($genitiveName);

            $category = Category::create([
                'name'               => $categoryName,
                'name_prepositional' => $catData['name_prepositional'] ?? null,
                'slug'               => $catSlug,
                'seo_title'          => "{$seoString} в Екатеринбурге — цены, сроки, гарантия",
                'seo_h1'             => $seoString,
                'status'             => 'active',
            ]);

            foreach ($catData['services'] as $svcSlug => $svcName) {
                $price = $priceMap[$catSlug][$svcSlug] ?? 1000;

                $uniqueSlug = str_starts_with($svcSlug, $catSlug) ? $svcSlug : $catSlug . '-' . $svcSlug;
                // Услуга может уже существовать из базового списка или другой категории
                $service = Service::firstOrCreate(
                    ['slug' => $uniqueSlug],
                    [
                        'name'          => $svcName,
                        'price_from'    => $price,
                        'duration_text' => '30 минут',
                        'status'        => 'active',
                    ]
                );

                // Привязываем услугу к категории
                DB::table('category_service')->insertOrIgnore([
                    'category_id' => $category->id,
                    'service_id'  => $service->id,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);

                // ServiceScope — связка Category + Service (scope_type = 'category')
                ServiceScope::create([
                    'scope_type' => 'category',
                    'scope_id'   => $category->id,
                    'service_id' => $service->id,
                    'price_from' => $price,
                    'seo_title'  => "{$svcName} — {$catData['name']} в Екатеринбурге",
                    'seo_h1'     => "{$svcName} — {$catData['name']}",
                ]);
            }

            $this->command->info("  ✓ {$catData['name']}: услуги и срезы ServiceScope созданы");
        }

        // ═══════════════════════════════════════════════════════════
        // 5. ПОЛОМКИ (Defects)
        // ═══════════════════════════════════════════════════════════
        $this->command->info('Создаем поломки (Defects)...');

        $defectsData = require __DIR__.'/data/defects_data.php';
        $allServices = Service::all()->keyBy('slug');
        $allCategories = Category::all()->keyBy('slug');

        foreach ($defectsData as $d) {
            $serviceId = null;
            if ($d['service'] !== null && $allServices->has($d['service'])) {
                $serviceId = $allServices[$d['service']]->id;
            }

            $categoryId = null;
            if (isset($d['cat']) && $allCategories->has($d['cat'])) {
                $categoryId = $allCategories[$d['cat']]->id;
            }

            Defect::create([
                'name'          => $d['name'],
                'slug'          => $d['slug'],
                'description'   => $d['name'],
                'icon_svg'      => $d['icon'] ?? null,
                'service_id'    => $serviceId,
                'category_id'   => $categoryId,
                'is_active'     => true,
            ]);
        }

        // ═══════════════════════════════════════════════════════════
        // 6. ТЕСТОВЫЕ ДАННЫЕ (Лиды, Отзывы, Кейсы)
        // ═══════════════════════════════════════════════════════════
        $this->command->info('Создаем тестовые данные (Leads, Reviews, Cases)...');

        Lead::updateOrCreate(
            ['phone' => '+7 (912) 345-67-89'],
            [
                'name'       => 'Иван Петров',
                'comment'    => 'Разбил стекло на iPhone 17, сколько будет стоить?',
                'page_url'   => '/remont-telefonov/apple/iphone-17/zamena-stekla',
                'utm_source' => 'yandex',
                'status'     => 'new',
            ]
        );

        Review::updateOrCreate(
            ['client_name' => 'Александр Кузнецов', 'device_name' => 'Ремонт iPhone 13'],
            [
                'text'         => 'Обратился с разбитым экраном iPhone 13. Все сделали за 40 минут, дисплей как новый, Face ID работает. Очень доволен сервисом и отношением мастера.',
                'rating'       => 5,
                'is_published' => true,
                'published_at' => now()->subDays(10)->toDateString(),
            ]
        );

        Review::updateOrCreate(
            ['client_name' => 'Марина Орлова', 'device_name' => 'Замена батареи Samsung Galaxy S23'],
            [
                'text'         => 'Телефон стал быстро разряжаться, в сервисе сразу провели диагностику и предложили замену аккумулятора. Сделали в тот же день, теперь держит заряд отлично.',
                'rating'       => 5,
                'is_published' => true,
                'published_at' => now()->subDays(6)->toDateString(),
            ]
        );

        Review::updateOrCreate(
            ['client_name' => 'Дмитрий Соколов', 'device_name' => 'Ремонт MacBook Air M2'],
            [
                'text'         => 'После попадания жидкости MacBook не включался. В другом сервисе сказали, что только замена платы, а здесь смогли восстановить и сохранить данные. Спасибо за профессионализм.',
                'rating'       => 5,
                'is_published' => true,
                'published_at' => now()->subDays(3)->toDateString(),
            ]
        );

        \App\Models\DeviceCase::updateOrCreate(
            ['title' => 'Замена стекла iPhone 13 Pro'],
            [
                'description'  => 'Упал на асфальт, экран работал исправно, но стекло было в паутине. Поменяли стекло с сохранением оригинальной матрицы.',
                'image_before' => 'https://placehold.co/600x400/EEE/31343C?text=iPhone+До',
                'image_after'  => 'https://placehold.co/600x400/EEE/31343C?text=iPhone+После',
                'price'        => 7500,
                'duration'     => '1.5 часа',
                'is_published' => true,
            ]
        );

        \App\Models\DeviceCase::updateOrCreate(
            ['title' => 'Замена аккумулятора Samsung S22 Ultra'],
            [
                'description'  => 'Телефон быстро садился и выключался на холоде. Установили оригинальный аккумулятор, восстановили влагозащиту.',
                'image_before' => 'https://placehold.co/600x400/EEE/31343C?text=Samsung+До',
                'image_after'  => 'https://placehold.co/600x400/EEE/31343C?text=Samsung+После',
                'price'        => 4200,
                'duration'     => '40 минут',
                'is_published' => true,
            ]
        );

        \App\Models\DeviceCase::updateOrCreate(
            ['title' => 'Восстановление MacBook Pro M1 после залития'],
            [
                'description'  => 'Пролили кофе на клавиатуру. Ноутбук перестал включаться. Произвели чистку в ультразвуковой ванне и пайку цепей питания.',
                'image_before' => 'https://placehold.co/600x400/EEE/31343C?text=MacBook+До',
                'image_after'  => 'https://placehold.co/600x400/EEE/31343C?text=MacBook+После',
                'price'        => 15000,
                'duration'     => '2 дня',
                'is_published' => true,
            ]
        );

        // ═══════════════════════════════════════════════════════════
        // 7. SEO-ТЕКСТЫ ДЛЯ СТРАНИЦ КАТЕГОРИЙ И БРЕНДОВ
        // ═══════════════════════════════════════════════════════════
        $this->command->info('Добавляем SEO-тексты (seo_bottom_text)...');

        $phonesText = '<p>Современные смартфоны — сложные электронные устройства, в которых объединены дисплейные модули, аккумуляторы, камеры, платы управления, другие компоненты, а также программное обеспечение. Даже небольшая поломка может существенно повлиять на работу сотового телефона или полностью вывести его из строя.</p>
<p>В большинстве случаев гаджет можно отремонтировать. Замена отдельных компонентов или восстановление программной части позволяет вернуть смартфону полноценную работоспособность.</p>
<h2>Что лучше — ремонт старого телефона или покупка нового</h2>
<p>При поломке многие пользователи задумываются о покупке нового устройства. Однако в большинстве случаев стоимость ремонта обычно ниже цены нового смартфона. Особенно это актуально для моделей среднего и премиального сегмента. Ремонт позволяет сохранить функциональность устройства и избежать лишних затрат.</p>
<p>Важен и психологический момент. Пользователь уже привык к своему телефону, настройкам и установленным приложениям. После ремонта не требуется переносить данные, заново настраивать систему или адаптироваться к новому интерфейсу.</p>
<p>Покупка нового мобильного телефона оправдана в ситуациях, когда устройство имеет серьезные повреждения или стоимость ремонта сопоставима с ценой нового аппарата. В таких случаях специалисты сервисного центра предупреждают клиента о нецелесообразности восстановления.</p>
<h2>Востребованные услуги</h2>
<p>Смартфоны обычно выходят из строя из-за механических повреждений, износа компонентов, попадания влаги или программных сбоев. Наиболее востребованные виды ремонта телефонов:</p>
<ul>
<li><strong>Замена дисплейного модуля.</strong> Повреждение экрана является одной из самых частых причин обращения в сервис. Падение телефона может привести к появлению трещин, пятен или полной потере изображения. В таких случаях проводится замена дисплейного модуля или стекла.</li>
<li><strong>Устранение программных сбоев.</strong> Специалисты приведут в порядок операционную систему, очистят устройство от вирусов и рекламных модулей, избавят от «зависаний» и прочих ошибок.</li>
<li><strong>Замена аккумулятора.</strong> Со временем батарея теряет емкость и начинает быстро разряжаться. Телефон может выключаться при низком заряде или плохо держать его в течение дня. Замена аккумулятора позволяет восстановить автономность устройства.</li>
<li><strong>Ремонт разъемов и кнопок.</strong> Частое использование приводит к механическому износу и поломкам. Ослабевают или повреждаются контакты, ломаются кнопки. В мастерской проводится замена или восстановление этих элементов.</li>
<li><strong>Восстановление после попадания влаги.</strong> Проникновение жидкости под корпус вызывает короткое замыкание и перегорание электронных компонентов. Специалисты выполняют сушку устройства и меняют поврежденные детали.</li>
</ul>
<p>Каждый вид ремонта требует профессионального подхода. Самостоятельные попытки лишь усугубляют ситуацию.</p>
<h2>Этапы сотрудничества</h2>
<p>Процесс ремонта телефона может зависеть от особенностей конкретной модели, но в целом складывается по следующему алгоритму:</p>
<ul>
<li><strong>Бесплатная диагностика мобильной техники.</strong> Используются профессиональные методики и тестовое оборудование. Это позволяет определить точную причину неисправности.</li>
<li><strong>Консультация и объяснение сути поломки.</strong> Специалисты рассказывают, какие компоненты повреждены и почему случилась неисправность. Обсуждаются возможные варианты восстановления устройства.</li>
<li><strong>Согласование методики ремонта и его стоимости.</strong> Сумма оговаривается заранее и впоследствии не увеличивается.</li>
<li><strong>Устранение неисправностей и тестирование.</strong> После согласования мастер приступает к ремонту. Выполняется замена или восстановление поврежденных компонентов. После завершения работ устройство проходит проверку работоспособности.</li>
</ul>
<p>Отремонтированный смартфон выдается клиенту. Оформляется гарантия (она действует на установленные детали и выполненные работы), проводятся расчеты.</p>
<h2>Советы по уходу за мобильным телефоном</h2>
<p>Даже самый надежный смартфон требует аккуратного обращения. Правильный уход помогает снизить риск поломок и продлить срок службы устройства. Полезные рекомендации:</p>
<ul>
<li><strong>Использование защиты.</strong> Чехол и защитное стекло помогают защитить устройство от механических повреждений. При падении они принимают на себя часть удара. Это значительно снижает вероятность растрескивания экрана или корпуса. Недорогая защита может предотвратить затратный ремонт.</li>
<li><strong>Осторожное обращение с зарядкой.</strong> Не используйте поврежденные кабели или контрафактные зарядные устройства низкого качества. Это может привести к перегреву или повреждению аккумулятора. Также важно не дергать кабель во время зарядки — в противном случае возможны поломки разъема питания.</li>
<li><strong>Защита от влаги и загрязнений.</strong> Попадание воды и пыли может привести к фатальному повреждению внутренних компонентов. Не стоит использовать телефон в условиях повышенной влажности или запыленности, а также оставлять его рядом с жидкостями в открытой таре. Эффективное средство — водозащитный чехол.</li>
</ul>
<p>Обращайтесь в компанию «Свой Мастер» в Екатеринбурге по телефону или через сайт. Специалисты подскажут, сколько будет стоить ремонт конкретного телефона, ответят на все сопутствующие вопросы.</p>';

        $tabletsText = '<p>Большинство проблем с планшетами решается путем замены отдельных компонентов или настройки программной части. В сервисном центре «Свой Мастер» такие работы выполняются аккуратно и безопасно для устройства. После ремонта планшет будет работать еще длительное время без необходимости покупки нового гаджета.</p>
<h2>Почему планшетам нужен профессиональный ремонт</h2>
<p>Конструкция девайса отличается высокой плотностью размещения компонентов. Внутри корпуса находятся дисплейный модуль, аккумулятор, системная плата, камеры, шлейфы и множество мелких деталей. Для ремонта требуется профессиональный подход, кустарное вмешательство приведет к дополнительным поломкам. Кроме этого, отдавать гаджет в мастерскую важно при необходимости:</p>
<ul>
<li><strong>Точной диагностики.</strong> Поломка планшета не всегда очевидна. Например, проблемы с зарядкой могут быть обусловлены разъемом, аккумулятором или контроллером питания. Мастер проводит диагностику с использованием специального оборудования и тестовых программ, что позволяет безошибочно установить источник неисправности.</li>
<li><strong>Доступа к запчастям.</strong> Необходимо устанавливать сертифицированные детали от известных производителей. Некачественные комплектующие могут быстро выйти из строя и привести к поломкам сопряженных компонентов.</li>
<li><strong>Соблюдения заводских техрегламентов.</strong> Чтобы устранять неполадки, нужно знать стандарты, правила и допуски заводов-изготовителей. Малейшее отклонение приведет к порче устройства.</li>
</ul>
<p>Профессиональный ремонт позволяет избежать дополнительных сложностей и обеспечивает корректную работу планшета после восстановления.</p>
<h2>Основные причины поломок</h2>
<p>Даже при аккуратном использовании планшеты могут выходить из строя. Основные причины неисправностей:</p>
<ul>
<li><strong>Механические повреждения.</strong> Падения и удары могут привести к трещинам на экране, корпусе или повреждению внутренних элементов. Даже если планшет выглядит целым, внутри могут пострадать шлейфы или системная плата.</li>
<li><strong>Воздействие влаги.</strong> Если она попадает под корпус, короткое замыкание почти гарантировано. Некоторые элементы могут пострадать также от коррозии. В такой ситуации устройство следует срочно отдавать в сервисный центр.</li>
<li><strong>Проблемы с операционной системой или программным обеспечением.</strong> Распространенные ситуации — когда планшет «зависает», самопроизвольно перезагружается или отключается.</li>
<li><strong>Износ батареи.</strong> Со временем она теряет емкость, хуже держит заряд, особенно при использовании энергоемких приложений. Иногда аккумулятор перегревается или вздувается. Проблема решается его заменой.</li>
</ul>
<p>К поломкам чаще всего приводят естественный износ, несоблюдение правил эксплуатации и невнимательность владельца.</p>
<h2>Популярные услуги</h2>
<p>Наш сервисный центр выполняет все виды ремонта планшетов. Наиболее востребованные услуги:</p>
<ul>
<li><strong>Замена стекла или дисплейного модуля в сборе.</strong> Экран — одна из самых уязвимых частей планшета. После падения на нем могут появиться трещины, исчезнуть сенсорная чувствительность. После ремонта устройство выглядит как новое и корректно реагирует на прикосновения.</li>
<li><strong>Замена аккумулятора.</strong> Это естественный процесс, поскольку ресурс любой батареи ограничен. Процедура выполняется с соблюдением всех технических требований.</li>
<li><strong>Ремонт механических компонентов (разъемов, кнопок).</strong> При интенсивном или неаккуратном использовании они расшатываются и повреждаются. В таких случаях производится замена.</li>
<li><strong>Устранение программных сбоев.</strong> Обычно они возникают из-за вирусов и рекламных модулей, возможны также другие причины.</li>
</ul>
<p>Каждый вид ремонта выполняется с учетом особенностей конкретной модели планшета и характера неисправности.</p>
<h2>Сколько стоит ремонт планшета в Екатеринбурге?</h2>
<p>Цена рассчитывается на основе прайс-листа, который опубликован на сайте сервиса, а также следующих факторов:</p>
<ul>
<li><strong>Сложность поломки.</strong> Некоторые неисправности устраняются быстро и без больших трудозатрат, другие требуют серьезного вмешательства. Это напрямую влияет на стоимость ремонта.</li>
<li><strong>Модель и конструкция планшета.</strong> Одна и та же поломка на одном устройстве может стоить на порядок дешевле, чем на другом.</li>
<li><strong>Тип используемых комплектующих.</strong> Фирменные детали дороже, но производители планшетных компьютеров настаивают на их использовании. Аналоги дешевле, это хороший выбор для девайсов с истекшим гарантийным сроком.</li>
</ul>
<p>Наш сервисный центр предлагает несколько вариантов ремонта, клиент сам выбирает оптимальное решение. В любом случае качество работ и установленных компонентов подтверждается официальной гарантией. Диагностика делается бесплатно, по ее итогам специалист объясняет клиенту суть неисправностей, согласовывает стоимость и сроки ремонта. При необходимости возможно срочное обслуживание.</p>
<p>Для получения дополнительной информации и оформления заявки обращайтесь через онлайн-форму или звоните по телефону.</p>';

        $appleText = '<p>Даже самые надежные iPhone иногда дают сбой. Разбитый экран, севший аккумулятор, проблемы со звуком могут выбить из привычного ритма жизни. Сервисный центр «Свой Мастер» (Екатеринбург) вернет к жизни любой iPhone — и модели прошлых лет, и новинки.</p>
<h2>Причины поломок iPhone</h2>
<p>Основная причина — механические повреждения. Случайно уронили телефон на плитку? Результат — трещины на стекле, вмятины на корпусе, вышедший из строя дисплей. Другая распространенная проблема — влага. Даже наличие защиты от брызг не спасает при долгом нахождении аппарата в воде или сыром месте.</p>
<p>Также техника Apple страдает от скачков напряжения при зарядке дешевыми неоригинальными блоками питания. Происходит естественный износ деталей: аккумулятор теряет емкость, динамики работают хуже, разъемы выходят из строя.</p>
<p>«Свой Мастер» принимает заявки по перечисленным и иным проблемам. Специалисты ремонтируют мобильную технику с 2010 года. Проводится бесплатная диагностика для определения причин поломки и согласования стоимости ремонта. Выдуманные неисправности и накрученные цены исключены — работа ведется честно и прозрачно.</p>
<h2>Качество, заслуживающее доверия</h2>
<p>Главный страх при ремонте iPhone — дешевые запчасти, ломающиеся через месяц. «Свой Мастер» использует качественные комплектующие, обеспечивающие длительную службу. Детали закупаются напрямую у официальных дистрибьюторов, что обуславливает качество и приемлемые цены. Предоставляется гарантия на работы — сроком до 2 лет.</p>
<p>Преимущества сервиса:</p>
<ul>
<li><strong>Бесплатная диагностика.</strong> Сначала определяется проблема, потом принимается решение о ремонте. Плата за осмотр не взимается.</li>
<li><strong>Ремонт при клиенте.</strong> Большинство неисправностей устраняется оперативно, ожидание занимает минимум времени. Клиент наблюдает за процессом либо занимается делами — возврат телефона производится быстро.</li>
<li><strong>Прозрачная цена.</strong> Стоимость включает работу мастера и детали. Скрытые платежи отсутствуют. Условия фиксируются в договоре до старта ремонта и остаются неизменными.</li>
<li><strong>Сохранность данных.</strong> Гарантируется полная конфиденциальность и защита личной информации.</li>
</ul>
<h2>Чего следует избегать</h2>
<p>Интернет пестрит советами по самостоятельному ремонту iPhone. Подобные действия часто приводят к печальным последствиям. Неподходящие инструменты, отсутствие опыта, сомнительные запчасти не решают проблему, а окончательно портят устройство. После такого вмешательства восстановление телефона усложняется и дорожает.</p>
<p>Доверять технику рекомендуется только профессионалам. Обращение в «Свой Мастер» гарантирует полноценное восстановление функциональности смартфона. Применяются проверенные методики и современное оборудование, возвращающие iPhone к идеальной работе.</p>
<p>Свяжитесь с нами, чтобы уточнить, сколько стоит ремонт вашего устройства, и получить другую интересующую информацию.</p>';

        $samsungText = '<p>Смартфоны Samsung сочетают инновационные решения и высокую производительность. Однако даже при использовании качественных материалов и современных технологий защиты любой мобильный телефон подвержен риску поломок. Интенсивная эксплуатация, механические воздействия или программные сбои могут нарушить работоспособность гаджета.</p>
<h2>Основные типы и причины неисправностей</h2>
<p>В числе распространенных неполадок:</p>
<ul>
<li>разбитый экран, неработающий сенсор;</li>
<li>проблемы с зарядкой, быстрый разряд аккумулятора;</li>
<li>отсутствие звука, неисправность микрофона;</li>
<li>повреждения корпуса, кнопок управления;</li>
<li>скопление пыли или влаги под стеклом камеры.</li>
</ul>
<p>Наиболее частыми причинами поломок являются механические воздействия: падения, удары, сдавливания. Это часто влечет разрушение стекла, появление трещин на матрице, деформацию корпуса или выход из строя внутренних компонентов.</p>
<p>Второй по частоте фактор — контакт устройства с жидкостью. Несмотря на наличие влагозащиты во флагманских моделях, погружение в воду или длительное нахождение во влажной среде способно вызвать коррозию контактов и окисление платы.</p>
<p>Также представляет опасность использование несертифицированных зарядных аксессуаров. Перепады напряжения могут вывести из строя контроллер питания или аккумуляторную батарею.</p>
<h2>Обращение к профессионалам — экономия времени и средств</h2>
<p>Самостоятельное вмешательство в сложную электронику Samsung без специальных знаний и оборудования часто оборачивается усугублением ситуации. Неквалифицированная замена деталей, повреждение шлейфов, неправильная пайка могут привести к тому, что восстановить аппарат будет невозможно либо стоимость ремонта возрастет многократно.</p>
<p>Доверив устройство специалистам, вы минимизируете риски и получаете гарантированный результат.</p>
<h2>Почему мы</h2>
<p>Сервисный центр «Свой Мастер» в Екатеринбурге предлагает профессиональное восстановление телефонов Samsung любой модели. Мы работаем с 2010 года, гарантируем надежный результат и индивидуальный подход к каждому клиенту.</p>
<p>Мы строим работу на принципах прозрачности и честности. Наши инженеры не придумывают несуществующих поломок и не навязывают лишних услуг. Все условия ремонта фиксируются в договоре и не меняются в процессе. Клиент всегда знает итоговую цену до начала работ.</p>
<p>Ключевые достоинства нашего сервиса:</p>
<ul>
<li><strong>Бесплатная диагностика.</strong> Установим причину неисправности и предложим оптимальный способ восстановления.</li>
<li><strong>Ремонт в кратчайшие сроки.</strong> Большинство неполадок устраняется максимально оперативно, в присутствии заказчика.</li>
<li><strong>Качественные запчасти.</strong> Мы используем оригинальные комплектующие. Прямые поставки позволяют сохранять высокое качество и приемлемые цены.</li>
<li><strong>Гарантия до двух лет.</strong> Мы уверены в своем профессионализме и предоставляем длительные обязательства на все виды работ.</li>
<li><strong>Конфиденциальность.</strong> Личные данные, фотографии и документы остаются в полной сохранности. Мы гарантируем их защиту.</li>
</ul>
<p>Чтобы уточнить, сколько стоит ремонт вашего гаджета, свяжитесь с нами.</p>';

        $xiaomiText = '<p>Смартфоны Xiaomi ценятся пользователями за оптимальное соотношение цены и функциональности. Эти устройства оснащаются производительными процессорами, качественными дисплеями и емкими аккумуляторами.</p>
<p>Однако даже у такой техники в процессе эксплуатации случаются поломки. Механические повреждения, программные сбои или естественный износ деталей требуют квалифицированного вмешательства.</p>
<h2>Распространенные причины и виды неисправностей</h2>
<p>Наиболее часто владельцы телефонов Xiaomi сталкиваются с последствиями падений и ударов. Разбитый экран, трещины на корпусе, повреждение внутренних компонентов — все это требует замены деталей.</p>
<p>Попадание влаги внутрь устройства также представляет серьезную опасность. Жидкость вызывает окисление контактов и может привести к короткому замыканию.</p>
<p>Использование несертифицированных зарядных аксессуаров нередко становится причиной выхода из строя контроллера питания или аккумулятора. Со временем происходит естественное старение компонентов: батарея теряет емкость, ухудшается работа динамиков, появляются сбои в работе разъемов.</p>
<p>В числе частых неполадок:</p>
<ul>
<li>нарушение целостности дисплея, неработающий сенсор;</li>
<li>проблемы с зарядкой, быстрый разряд аккумулятора;</li>
<li>отсутствие звука, неисправность микрофона или динамика;</li>
<li>повреждения корпуса, кнопок управления;</li>
<li>загрязнение объектива камеры, посторонние частицы под стеклом.</li>
</ul>
<p>Самостоятельное вмешательство в работу смартфона без специальных знаний и оборудования часто усугубляет проблему. Неквалифицированная замена деталей может привести к повреждению других узлов, и последующее восстановление потребует значительно больших вложений.</p>
<h2>Почему нам доверяют</h2>
<p>Сервисный центр «Свой Мастер» в Екатеринбурге строит работу на принципах честности и прозрачности. Наши инженеры не придумывают несуществующих поломок и не навязывают ненужных услуг. Все условия ремонта фиксируются в договоре и остаются неизменными до завершения работ. Клиент заранее знает окончательную цену.</p>
<p>Основные достоинства сервиса:</p>
<ul>
<li><strong>Бесплатная диагностика.</strong> Специалисты центра определят причину неисправности и предложат оптимальный способ восстановления.</li>
<li><strong>Оперативный ремонт.</strong> Большинство неполадок устраняется в присутствии заказчика. Мы ценим ваше время и не затягиваем сроки.</li>
<li><strong>Качественные комплектующие.</strong> Для ремонта используются запчасти, соответствующие техническим требованиям. Работаем напрямую с официальными дилерами.</li>
<li><strong>Прозрачное ценообразование.</strong> Итоговая стоимость складывается из цены запчастей и оплаты работы мастера. Никаких скрытых платежей.</li>
<li><strong>Гарантия до двух лет.</strong> Мы уверены в качестве работ и предоставляем длительные сервисные обязательства.</li>
<li><strong>Конфиденциальность.</strong> Личные данные, фотографии и документы остаются в сохранности. Доступ посторонних к информации исключен.</li>
</ul>
<p>Обратившись в «Свой Мастер», вы минимизируете риски. Наши специалисты владеют актуальной информацией об особенностях моделей Xiaomi, используют современное оборудование и проверенные методики. Это позволяет вернуть устройству функциональность в кратчайшие сроки.</p>';

        $honorText = '<p>Смартфоны Honor пользуются устойчивым спросом благодаря продуманному дизайну, качественным камерам и стабильной работе. Однако даже надежная техника в процессе эксплуатации может давать сбои.</p>
<p>Сервисный центр «Свой Мастер» в Екатеринбурге предлагает профессиональный ремонт телефонов Honor любой модели. Мы работаем с 2010 года и гарантируем высокое качество обслуживания.</p>
<h2>Причины возникновения неисправностей</h2>
<p>Наиболее распространенный фактор — механические воздействия. Падение устройства на твердую поверхность приводит к повреждению дисплея, появлению трещин на стекле, деформации корпуса.</p>
<p>Воздействие жидкости также представляет опасность. Контакт с водой вызывает коррозию элементов, окисление контактов на плате.</p>
<p>Использование зарядных устройств, не соответствующих техническим параметрам, нередко влечет повреждение контроллера питания, выход аккумулятора из строя. В процессе длительной эксплуатации происходит естественный износ: снижается емкость батареи, ухудшается работа динамиков, нарушается функционирование разъемов.</p>
<h2>Виды неисправностей</h2>
<p>К числу частых неполадок относятся:</p>
<ul>
<li>нарушение целостности экрана, отсутствие реакции на касания;</li>
<li>невозможность зарядить устройство, быстрый разряд;</li>
<li>повреждения корпуса, сколы, потертости;</li>
<li>отсутствие звука, неработающий микрофон;</li>
<li>сбой в работе кнопок включения и регулировки громкости;</li>
<li>загрязнение камеры, появление пыли под защитным стеклом.</li>
</ul>
<h2>Принципы нашей работы</h2>
<p>Деятельность сервисного центра «Свой Мастер» строится на открытости и соблюдении интересов клиента. Специалисты не создают искусственных проблем, не предлагают ненужных услуг. До начала ремонта с заказчиком согласовываются условия, включая окончательную стоимость и перечень операций. Достигнутые договоренности фиксируются в документации, сохраняя силу до завершения работ.</p>
<p>Обращение к нам предоставляет клиентам ряд значимых преимуществ:</p>
<ol>
<li><strong>Бесплатная диагностика.</strong> Специалисты проведут анализ состояния устройства, установят причину неполадки, предложат обоснованные рекомендации. Оплата за диагностику не взимается.</li>
<li><strong>Оперативность выполнения.</strong> Большинство неисправностей устраняется в присутствии владельца либо в минимально возможные сроки. Мы ориентированы на быстрое обслуживание.</li>
<li><strong>Качественные комплектующие.</strong> Для ремонта используются детали, соответствующие техническим требованиям. Прямые поставки позволяют контролировать качество и поддерживать доступные цены.</li>
<li><strong>Длительная гарантия.</strong> Мы предоставляем обязательства сроком до двух лет. При возникновении проблем по нашей вине их устранение производится бесплатно.</li>
<li><strong>Сохранность данных.</strong> Личная информация, хранящаяся в памяти устройства, остается конфиденциальной. Доступ посторонних к фотографиям и документам исключен.</li>
</ol>
<p>Обращение в «Свой Мастер» гарантирует, что ваше устройство попадет в руки опытных специалистов, владеющих информацией об особенностях моделей Honor и применяющих проверенные методики.</p>';

        $huaweiText = <<<'HTML'
<h2>Ремонт телефонов Huawei</h2><p>Смартфоны Huawei оснащаются собственными процессорами Kirin, качественными камерами Leica и фирменной оболочкой EMUI. Техническая сложность устройств требует глубоких знаний архитектуры и доступа к специализированному ПО.</p><p>Сервисный центр «Свой Мастер» в Екатеринбурге выполняет ремонт Huawei любой модели. Опыт с 2010 года позволяет нам эффективно справляться с неполадками.</p><h3>Как мы работаем</h3><p>Конструкция смартфонов Huawei часто предполагает неразборные корпуса с плотной посадкой компонентов, что усложняет замену дисплея, аккумулятора или задней крышки. Наши специалисты владеют технологией безопасного вскрытия таких устройств с сохранением заводской герметичности.</p><p>Перечень выполняемых работ включает:</p><ul><li>замену дисплейного модуля (в сборе или с отдельным стеклом);</li><li>восстановление аккумулятора и контроллера питания;</li><li>ремонт разъема зарядки, динамиков, микрофонов;</li><li>устранение последствий залития с чисткой платы ультразвуком;</li><li>программное обслуживание: перепрошивка, восстановление после обновлений, разблокировка при подтверждении прав собственности.</li></ul><p>После ремонта корпус собирается с применением фирменных клеевых составов, что сохраняет защиту от влаги.</p><h3>Почему мы</h3><p>Сервисный центр работает по принципу полной прозрачности. Инженеры не придумывают несуществующих неисправностей. Диагностика бесплатна, стоимость ремонта озвучивается до начала работ и фиксируется в договоре. Клиент может наблюдать за процессом в сервисе или забрать устройство в оговоренный срок.</p><p>Ключевые достоинства:</p><ol><li><b>Гарантия до двух лет</b> на работы и установленные компоненты.</li><li><b>Качественные комплектующие</b>, соответствующие заводским спецификациям. Прямые поставки исключают посреднические наценки.</li><li><b>Сохранность данных.</b> Личная информация, фотографии, документы остаются конфиденциальными.</li><li><b>Ремонт в присутствии клиента.</b> Большинство неисправностей устраняется оперативно.</li></ol><p>Самостоятельный ремонт Huawei без специального оборудования и доступа к сервисному ПО часто приводит к необратимым последствиям. Неправильное вскрытие повреждает шлейфы дисплея и сканера отпечатков. Установка некачественных запчастей вызывает сбои в работе. Доверив устройство специалистам сервиса «Свой Мастер», вы получаете полноценное восстановление с гарантией.</p>
HTML;

        $googlePixelText = <<<'HTML'
<h2>Ремонт телефонов Google Pixel</h2><p>Смартфоны Google Pixel — устройства, которые первыми получают обновления Android и предлагают лучшие алгоритмы обработки фото. Их распространенность в России ниже, чем у массовых брендов, что создает сложности с поиском качественного сервиса.</p><p>Центр «Свой Мастер» в Екатеринбурге входит в число немногих, кто профессионально ремонтирует Google Pixel всех поколений — от первого до актуальных серий 8 и 9 Pro. Солидный опыт работы позволяет нам разбираться с неисправностями любой сложности.</p><h3>С какими проблемами обращаются владельцы Pixel</h3><p>Наиболее часто к нам приходят с разбитыми экранами. Дисплеи Pixel имеют высокую плотность пикселей и требовательны к качеству замены. Использование неоригинальных модулей приводит к потере яркости, мерцанию или некорректной работе Always-On Display.</p><p>Вторая распространенная причина — проблемы с аккумулятором. Со временем батарея теряет емкость, телефон выключается при остатке заряда 20–30 %. Замена требует аккуратного вскрытия из-за плотного клеевого состава.</p><p>Также владельцы сталкиваются с выходом из строя разъема USB-C (особенно при использовании неоригинальных кабелей), поломкой кнопок питания и громкости, проблемами с микрофоном.</p><h3>Как выполняется сервис</h3><p>Процесс начинается с бесплатной диагностики. Специалист определяет причину неисправности, оценивает возможность ремонта и озвучивает стоимость. Условия фиксируются в договоре.</p><p>Далее мастер ведет работы с соблюдением технологии производителя:</p><ul><li>при замене экрана — демонтаж без повреждения платы и камеры, установка модуля с восстановлением герметизации;</li><li>при замене аккумулятора — аккуратное нагревание для размягчения клея, исключающее деформацию корпуса;</li><li>программные проблемы решаются перепрошивкой с сохранением данных (при возможности).</li></ul><p>После ремонта устройство проходит полное тестирование: звонки, камера, Wi-Fi, Bluetooth, сенсоры, работа кнопок и разъемов.</p><h3>Почему выбирают нас</h3><ol><li><b>Наличие качественных запчастей.</b> Комплектующие закупаются напрямую, что обеспечивает совместимость и качество.</li><li><b>Гарантия до двух лет.</b> Распространяется на все виды работ и установленные детали.</li><li><b>Прозрачная цена.</b> Договор подписывается до начала ремонта. Сумма формируется из стоимости запчасти и работы мастера. Дополнительных наценок нет.</li><li><b>Сохранность данных.</b> Личная информация не передается третьим лицам.</li></ol><p>Для записи на ремонт или консультации свяжитесь с нами. Ответим на все вопросы о стоимости и сроках.</p>
HTML;

        $textCamera = <<<'HTML'
<h2>Замена камеры</h2><p>Размытые снимки, темные пятна, отсутствие автофокуса, черный экран при запуске камеры или дрожание изображения — признаки выхода из строя основного или фронтального модуля. Сервисный центр «Свой Мастер» выполняет замену записывающих устройств на телефонах любых брендов. Работаем с 2010 года, гарантируем полное восстановление качества съемки.</p><h3>Почему камера выходит из строя</h3><p>Самые частые причины — механические удары и падения. Даже при внешней целостности корпуса внутренние компоненты модуля могут сместиться или разрушиться. Попадание пыли и влаги через микротрещины также ухудшает качество снимков. В некоторых случаях проблема в шлейфе, соединяющем модуль с платой, или в контроллере питания камеры.</p><p>Отдельная категория — выход из строя оптического стабилизатора. Изображение начинает «дергаться», особенно при съемке видео. Модуль подлежит полной замене: ремонт стабилизатора в условиях сервиса, как правило, экономически нецелесообразен.</p><h3>Как мы меняем камеру</h3><p>Процесс начинается с бесплатной диагностики. Специалист проверяет работу модулей, определяет характер неисправности. После согласования стоимости мастер приступает к работе.</p><p>Смартфон аккуратно вскрывается с использованием нагревательной платформы. Доступ к камере осуществляется через заднюю крышку или со стороны дисплея. Поврежденный модуль демонтируется, контакты очищаются. Устанавливается новая камера, соответствующая заводским спецификациям. После сборки проводится тестирование: фокусировка, вспышка, запись видео, переключение между объективами. Клиент может наблюдать за процессом в сервисе.</p><h4>Преимущества обращения в «Свой Мастер»:</h4><ul><li><b>Качественные комплектующие.</b> Используем камеры, соответствующие оригинальным характеристикам. Прямые поставки исключают подделки.</li><li><b>Прозрачная цена.</b> Стоимость фиксируется в договоре.</li><li><b>Сохранность данных.</b> Замена камеры не затрагивает личную информацию.</li><li><b>Гарантия до двух лет.</b> На установленный модуль и выполненные работы.</li></ul><p>Звоните, проконсультируем по стоимости и срокам.</p>
HTML;

        $textCameraGlass = <<<'HTML'
<h2>Замена стекла камеры</h2><p>Защитное стекло над объективом — уязвимый элемент смартфона. Трещина или скол делают съемку невозможной: изображение мутное, появляются блики, пыль и влага проникают внутрь. Сервисный центр «Свой Мастер» выполняет замену стекла камеры на телефонах любых моделей.</p><h3>Почему не стоит клеить самостоятельно</h3><p>В интернете много советов по самостоятельной замене стекла камеры «на суперклей». Это прямой путь к повреждению объектива и окончательному выходу модуля из строя. Неправильно подобранное стекло искажает изображение, а попавший внутрь клей делает ремонт невозможным. Доверьтесь профессионалам.</p><p>Если вовремя не заменить стекло, в дальнейшем может потребоваться уже замена самого модуля камеры — а это значительно дороже.</p><h3>Как проходит ремонт</h3><p>Сначала мастер проводит диагностику, чтобы убедиться, что модуль камеры не поврежден. Стекло нагревается для размягчения клея. Специалист аккуратно удаляет осколки, не повреждая корпус и объектив. Посадочное место очищается от остатков клея и пыли. Устанавливается новое стекло с использованием фирменного клеевого состава, обеспечивающего плотное прилегание и защиту от влаги. После фиксации проверяется работа камеры: фокусировка, качество изображения, отсутствие бликов.</p><p>Операция занимает от 30 до 60 минут. Клиент может ожидать завершения в сервисе.</p><h4>Почему выбирают «Свой Мастер»:</h4><ol><li><b>Бесплатная диагностика.</b> Оценка состояния без предоплаты.</li><li><b>Прозрачные условия.</b> Стоимость фиксируется в договоре.</li><li><b>Аккуратный монтаж.</b> Работы выполняются так, чтобы не повредить модуль. Используем профессиональный инструмент и качественные клеевые составы.</li><li><b>Гарантия до двух лет.</b> На установленное стекло и работы.</li></ol><p>Для консультации и записи звоните по телефону.</p>
HTML;

        $textChargingPort = <<<'HTML'
<h2>Замена разъема зарядки</h2><p>Телефон перестал заряжаться или делает это только в определенном положении кабеля — признак неисправности разъема зарядки (USB-C, Lightning, Micro-USB). Сервисный центр «Свой Мастер» выполняет замену данного элемента на телефонах любых брендов с гарантией до двух лет.</p><h3>Почему разъем выходит из строя</h3><p>Основная причина — механический износ. Ежедневные подключения кабеля постепенно расшатывают контакты. Частое использование неоригинальных проводов ускоряет процесс: неподходящий разъем создает дополнительную нагрузку. Попадание пыли, грязи и влаги вызывает окисление контактов и короткое замыкание. Проблема также возникает после резкого выдергивания кабеля или падения телефона в момент зарядки.</p><h3>Как происходит замена</h3><p>Процесс начинается с бесплатной диагностики. Специалист проверяет, действительно ли проблема в разъеме, а не в кабеле, зарядном блоке или контроллере питания.</p><p>Устройство вскрывается с использованием нагревательной платформы. Поврежденный разъем демонтируется. Выполняется пайка с соблюдением температурного режима, исключающего перегрев соседних компонентов. Устанавливается новый разъем. После сборки проводится тестирование: зарядка, передача данных, работа в наушниках.</p><p>Процесс занимает от 1 до 2 часов. Клиент может наблюдать за работой в сервисе.</p><h4>Надежно и честно</h4><p>Преимущества обращения в «Свой Мастер»:</p><ul><li><b>Качественные комплектующие.</b> Используем разъемы, соответствующие заводским спецификациям. Прямые поставки гарантируют совместимость.</li><li><b>Профессиональная пайка.</b> Специалисты имеют многолетний опыт работы с многослойными платами.</li><li><b>Прозрачная цена.</b> Стоимость фиксируется в договоре до начала работ.</li></ul><p>Для записи на ремонт звоните по контактному номеру. Проконсультируем по стоимости и срокам.</p>
HTML;

        $textWater = <<<'HTML'
<h2>Ремонт после залития</h2><p>Жидкость внутри смартфона — одна из самых коварных поломок. Даже если устройство продолжает работать, коррозия контактов приводит к серьезным последствиям. В сервисном центре «Свой Мастер» выполняют профессиональное восстановление техники после залития.</p><h3>Что происходит с телефоном при попадании влаги</h3><p>Вода или другая жидкость проникает внутрь корпуса через разъемы, динамики, кнопки. Даже при наличии влагозащиты гарантии полной герметичности нет. Жидкость вызывает окисление контактов, короткое замыкание, повреждение микросхем.</p><p>Со временем появляются проблемы: перестает работать сенсор, пропадает звук, телефон самопроизвольно перезагружается или вовсе не включается. Промедление увеличивает риск необратимых повреждений.</p><h3>Как мы восстанавливаем устройства</h3><p>Наши специалисты проводят полную диагностику для оценки масштаба повреждений. Работы выполняются поэтапно:</p><ul><li>вскрытие аппарата с соблюдением заводских рекомендаций;</li><li>демонтаж материнской платы и компонентов, подвергшихся воздействию жидкости;</li><li>очистка элементов ультразвуком с применением профессиональных растворов;</li><li>удаление окислов, просушка, проверка целостности дорожек и микросхем;</li><li>замена поврежденных деталей (разъемы, контроллеры, фильтры);</li><li>сборка, тестирование всех функций.</li></ul><p>Все этапы согласовываются с клиентом. При нецелесообразности ремонта мастер предложит другое оптимальное решение.</p><h3>Почему мы</h3><ul><li><b>Бесплатная диагностика:</b> специалист оценит состояние аппарата без предоплаты.</li><li><b>Прозрачные условия:</b> договор фиксирует стоимость и перечень работ до начала ремонта.</li><li><b>Качественные комплектующие:</b> заменяемые детали соответствуют техническим требованиям.</li><li><b>Гарантия до двух лет:</b> на выполненные работы и установленные компоненты.</li><li><b>Конфиденциальность:</b> личные данные на устройстве остаются в сохранности.</li></ul><p>Для уточнения деталей звоните по контактному номеру.</p>
HTML;

        $textBackCover = <<<'HTML'
<h2>Замена задней крышки</h2><p>Задняя панель современного смартфона — очень уязвимый элемент. Падение на твердую поверхность или просто неосторожное обращение приводят к появлению трещин, сколов, деформации. В сервисном центре «Свой Мастер» выполняют замену детали аккуратно и с гарантией качества.</p><h3>Когда это нужно</h3><p>Поврежденная задняя крышка — это не только эстетическая проблема. Острые сколы могут поранить руку или повредить одежду. Трещины нарушают герметичность корпуса, открывая доступ пыли и влаге к внутренним компонентам. Если камера или беспроводная зарядка перестали работать корректно, причиной часто становится деформация панели. Замена требуется также при подготовке устройства к продаже для повышения его стоимости.</p><h3>Как проходит процедура</h3><p>Процесс замены включает несколько этапов:</p><ul><li>предварительная оценка состояния корпуса и внутренних компонентов;</li><li>аккуратное нагревание панели для размягчения клеевого слоя;</li><li>отделение поврежденной крышки без риска для материнской платы, камеры и аккумулятора;</li><li>удаление остатков старого клея, очистка посадочных мест;</li><li>установка новой детали с использованием фирменного клеевого состава, обеспечивающего плотное прилегание;</li><li>фиксация панели, проверка работы кнопок, камеры, беспроводной зарядки.</li></ul><p>Все манипуляции производятся в присутствии заказчика либо в оговоренный срок.</p><h3>Почему нам доверяют</h3><ol><li><b>Диагностика без оплаты:</b> мастер определит объем работ и озвучит стоимость до начала ремонта.</li><li><b>Аккуратность:</b> специалисты имеют многолетний опыт работы с хрупкими панелями.</li><li><b>Качественные детали:</b> используются панели, соответствующие заводским спецификациям. Прямые поставки позволяют избежать посреднических наценок.</li><li><b>Гарантия 2 года:</b> на установленную крышку и выполненные работы.</li></ol><p>Работаем с моделями любых брендов. Звоните.</p>
HTML;

        $textMic = <<<'HTML'
<h2>Замена микрофона</h2><p>Проблемы с микрофоном делают телефон бесполезным для звонков. Собеседник перестает слышать, запись голоса искажается, голосовые помощники не распознают команды.</p><h3>Что вызывает неисправности:</h3><ul><li>Механические повреждения после падения нарушают контакт или целостность компонента.</li><li>Попадание влаги вызывает окисление контактов и короткое замыкание.</li><li>Засорение пылью и грязью через защитную сетку постепенно снижает чувствительность.</li><li>Естественный износ или заводской брак также возможны, но встречаются реже.</li></ul><p>Сервисный центр «Свой Мастер» осуществляет замену микрофонов на смартфонах любых марок. Многолетний опыт работы позволяет быстро вернуть устройству полноценную функциональность.</p><h3>Как мы ремонтируем</h3><p>Процесс восстановления начинается с бесплатной диагностики. Специалист определяет, какой именно микрофон вышел из строя и требуется ли замена других элементов (шлейфа, разъема, контроллера).</p><p>После согласования стоимости мастер выполняет работы: вскрытие аппарата с соблюдением технологии производителя; демонтаж поврежденного микрофона или замену шлейфа с пайкой; очистку посадочного места, проверку контактов; установку нового компонента, соответствующего техническим требованиям; сборку, калибровку, тестирование записи и звонков.</p><p>Ремонт производится в присутствии клиента либо в минимально возможные сроки.</p><h3>Причины обратиться к нам</h3><p><b>Честная цена:</b> стоимость оговаривается заранее и фиксируется в договоре.</p><p><b>Качественные запчасти:</b> используем детали, прошедшие входной контроль. Прямые поставки обеспечивают надежность и адекватную стоимость.</p><p><b>Гарантия 24 месяца:</b> на замененный микрофон и выполненные работы.</p><p><b>Сохранность данных:</b> личная информация на устройстве не подлежит разглашению.</p><p>Свяжитесь с нами по контактному номеру для консультации.</p>
HTML;

        $textSpeaker = <<<'HTML'
<h2>Замена динамика</h2><p>Отсутствие звука, посторонние шумы при разговоре или прослушивании музыки — признаки неисправности динамика смартфона. Специалисты сервисного центра «Свой Мастер» выполняют замену данного элемента на любой модели. Работаем с 2010 года, гарантируем результат.</p><h3>Почему динамик выходит из строя</h3><p>Чаще всего поломка вызвана попаданием мелкого мусора и пыли через защитную сетку. Со временем мембрана теряет подвижность, звук становится тихим или искаженным. Механические повреждения после удара могут нарушить контакт или целостность динамика. Попадание жидкости приводит к короткому замыканию и выходу компонента из строя. В некоторых случаях проблема кроется не в самом динамике, а в шлейфе, контроллере или разъеме.</p><h3>Как выполняется замена</h3><p>Специалисты центра проводят бесплатную диагностику для точного определения причины. Если требуется замена динамика, работы осуществляются поэтапно:</p><ul><li>аккуратное вскрытие корпуса с соблюдением заводской технологии;</li><li>демонтаж неисправного компонента;</li><li>очистка посадочного места, проверка контактных групп;</li><li>установка нового динамика, соответствующего параметрам модели;</li><li>сборка устройства, тестирование звука в режиме разговора, воспроизведения музыки, громкой связи.</li></ul><p>Все операции производятся в присутствии клиента. При необходимости мастер демонстрирует результаты тестирования до и после ремонта.</p><h3>Честность. Профессионализм. Ответственность</h3><p>Преимущества обращения в «Свой Мастер»:</p><ul><li><b>Прозрачные условия:</b> договор фиксирует стоимость и перечень работ до начала ремонта.</li><li><b>Качественные детали:</b> используем комплектующие, соответствующие техническим требованиям. Прямые поставки позволяют избежать лишних наценок.</li><li><b>Гарантия до 2 лет:</b> на установленный динамик и выполненные работы.</li><li><b>Конфиденциальность:</b> данные на устройстве остаются в сохранности.</li></ul><p>Доверьте ремонт профессионалам. Звоните для записи или консультации.</p>
HTML;

        $textFirmware = <<<'HTML'
<h2>Перепрошивка/Обновление ПО</h2><p>Программные сбои способны полностью парализовать работу смартфона. Постоянные перезагрузки, зависания, ошибки приложений, отсутствие сети, быстрое потребление заряда — симптомы, которые не всегда решаются стандартными настройками.</p><p>Специалисты сервисного центра «Свой Мастер» выполняют профессиональную перепрошивку телефонов любых брендов. Гарантируем конфиденциальность данных.</p><h3>Когда нужна и как выполняется перепрошивка</h3><p>Вирусное заражение, сбои после установки несовместимых приложений, проблемы с загрузкой — все это требует вмешательства специалиста. Также перепрошивка необходима при неудачном обновлении и для восстановления работы устройства после вмешательства в системные файлы.</p><p>Мы используем профессиональное оборудование и лицензионное программное обеспечение. Процесс включает несколько этапов:</p><ul><li>предварительная диагностика (выполняется бесплатно);</li><li>создание резервной копии;</li><li>подбор корректной версии прошивки, соответствующей региону и модели;</li><li>установка ПО с соблюдением заводских протоколов;</li><li>проверка работоспособности всех модулей (связь, Wi-Fi, камера, звук);</li><li>восстановление данных из резервной копии при необходимости.</li></ul><p>Все действия согласовываются с клиентом. При невозможности сохранить информацию мастер предупреждает об этом до начала работ.</p><h3>Почему обращаются к нам</h3><ol><li><b>Честная цена:</b> стоимость перепрошивки фиксируется в договоре и не меняется.</li><li><b>Прозрачность:</b> клиент информируется о каждом этапе.</li><li><b>Гарантийные обязательства:</b> вы получает уверенность в качестве выполненных работ.</li></ol><p>Самостоятельная перепрошивка с использованием непроверенных версий ПО может превратить смартфон в «кирпич». Доверьте восстановление программной части профессионалам. Звоните для консультации.</p>
HTML;

        $textUnlock = <<<'HTML'
<h2>Разблокировка/удаление пароля</h2><p>Забытый пароль, PIN-код или графический ключ могут сделать смартфон недоступным. В такой ситуации пользователь лишен возможности совершать звонки, просматривать документы, фото и т. п.</p><p>Специалисты сервисного центра «Свой Мастер» выполняют профессиональную разблокировку телефонов всех брендов. Опыт работы с 2010 года позволяет нам решать задачи любой сложности.</p><h3>Виды блокировок, с которыми работаем</h3><p>Мы снимаем различные типы защиты: графический ключ, PIN-код, пароль, сбой работы сканера отпечатков после замены компонентов. Разблокировка выполняется без вскрытия корпуса (при программном сбросе) либо с помощью аппаратного вмешательства в случаях, когда иные способы недоступны.</p><p>Важно: все работы проводятся только при наличии подтверждения принадлежности устройства владельцу.</p><h3>Этапы работы</h3><ol><li>Бесплатная диагностика для определения способа разблокировки и оценки возможности сохранения данных.</li><li>Согласование с клиентом стоимости и метода, подписание договора.</li><li>Выполнение разблокировки с использованием профессионального оборудования и лицензионного ПО.</li><li>Проверка работоспособности устройства, установка нового пароля по желанию клиента.</li><li>Передача телефона владельцу с сохраненной личной информацией (при возможности).</li></ol><p>Если сохранение данных невозможно, мастер предупреждает об этом до начала работ. Клиент принимает решение самостоятельно.</p><h3>Честность и профессионализм</h3><p>Главные принципы нашей работы:</p><ul><li><b>Прозрачность:</b> условия прописываются в договоре, не меняются в процессе.</li><li><b>Конфиденциальность:</b> доступ к личной информации ограничен, данные не передаются третьим лицам.</li><li><b>Легальность:</b> разблокировка выполняется с соблюдением законодательства, требуется подтверждение права собственности.</li></ul><p>На все виды работ предоставляем официальную гарантию. Свяжитесь с нами по телефону для записи.</p>
HTML;

        $textScreenGlass = <<<'HTML'
<h2>Замена стекла на смартфоне</h2><p>Треснувшее стекло на экране смартфона — ситуация, знакомая многим. Иногда дисплей под ним продолжает работать, сенсор реагирует на касания, изображение остается четким. В таком случае замена только стекла становится оптимальным решением. Это дешевле, чем обновлять весь модуль, при этом сохраняется оригинальная матрица.</p><p>Сервисный центр «Свой Мастер» в Екатеринбурге выполняет замену стекла на телефонах любых брендов. Мы располагаем необходимым оснащением и квалификацией для безупречного результата.</p><h3>Как происходит процедура</h3><p>Замена стекла — технологически сложный процесс, требующий специального оборудования. В центре «Свой Мастер» она выполняется поэтапно:</p><ol><li><b>Демонтаж дисплейного модуля.</b> Специалист аккуратно отсоединяет экран от корпуса с использованием нагревательных платформ.</li><li><b>Отделение разбитого стекла.</b> Устройство фиксируется на вакуумном столе, мастер с помощью специальной струны отделяет стекло от матрицы. Работа ведется под микроскопом.</li><li><b>Очистка и обезжиривание.</b> Удаляются остатки старого клея, поверхность матрицы подготавливается к установке нового стекла.</li><li><b>Приклейка.</b> В автоклаве новое стекло с клеящим слоем соединяется с матрицей, исключаются пузырьки воздуха.</li><li><b>Сборка и тестирование.</b> Модуль устанавливается в корпус, проверяется работа сенсора, яркость, отсутствие засветов и пыли.</li></ol><p>Процесс занимает от 2 до 4 часов. Клиент может наблюдать за работой или забрать устройство в оговоренное время.</p><h3>Причины обратиться к нам</h3><ul><li><b>Бесплатная диагностика.</b> Мастер оценит возможность замены стекла и назовет окончательную стоимость до начала работ.</li><li><b>Качественные материалы.</b> Используются стекла с заводским клеящим слоем, обеспечивающие прозрачность и чувствительность сенсора.</li><li><b>Честные условия.</b> Стоимость фиксируется в договоре, никаких доплат после ремонта.</li><li><b>Сохранность данных.</b> Устройство не подвергается перепрошивке, личная информация остается в безопасности.</li><li><b>Гарантия до двух лет.</b> На выполненные работы и установленное стекло.</li></ul>
HTML;

        $textDisplay = <<<'HTML'
<h2>Замена дисплея на смартфоне</h2><p>Разбитый экран смартфона — лидер среди причин обращения в сервисные центры. Установка дисплея в сборе требуется, когда повреждена сама матрица: появляются черные пятна, цветные полосы, сенсор не реагирует на касания. Сервисный центр «Свой Мастер» в Екатеринбурге работает с телефонами любых брендов и моделей.</p><h3>Этапы ремонта</h3><p>Процесс начинается с бесплатной диагностики, мастер определяет тип повреждения, подбирает совместимый модуль и согласовывает стоимость. После подписания договора выполняются работы:</p><ol><li><b>Демонтаж поврежденного экрана.</b> Корпус нагревается на платформе для размягчения клея. Мастер аккуратно отсоединяет модуль, сохраняя целостность шлейфов и платы.</li><li><b>Очистка посадочного места.</b> Удаляются остатки клея, грязь, пыль. Проверяется состояние корпуса — при деформациях проводится выравнивание.</li><li><b>Установка нового модуля.</b> Дисплей фиксируется на клеевой состав. В моделях с влагозащитой восстанавливается герметичность.</li><li><b>Сборка и калибровка.</b> Проводится тестирование сенсора, яркости, цветопередачи, датчика приближения и сканера отпечатков.</li><li><b>Финальная проверка.</b> Устройство проходит тесты: звонки, камера, беспроводные интерфейсы и пр.</li></ol><p>Ремонт проводится в срок от 1 до 3 часов.</p><h3>Почему обращаются к нам</h3><ul><li><b>Качественные дисплеи.</b> Используем оригинальные модули либо лицензированные аналоги с полной цветопередачей и корректной работой сенсора.</li><li><b>Гарантия до двух лет.</b> На все работы и на установленные дисплеи.</li><li><b>Прозрачная цена.</b> Стоимость оговаривается заранее и фиксируется в договоре.</li><li><b>Сохранность данных.</b> При замене экрана информация на телефоне не затрагивается.</li><li><b>Ремонт в присутствии.</b> При желании клиент может наблюдать за процессом работы.</li></ul><h3>Что будет, если не заменить разбитый экран</h3><p>Эксплуатировать смартфон с треснувшим стеклом опасно. Острые осколки могут поранить руки. Через трещины внутрь корпуса проникает пыль и влага, что приводит к более серьезным поломкам — короткому замыканию, выходу из строя материнской платы. Чем раньше обратиться в сервис, тем ниже вероятность дополнительных затрат.</p>
HTML;

        $textBattery = <<<'HTML'
<h2>Замена аккумулятора на телефоне</h2><p>Самые частые признаки изношенного аккумулятора — телефон перестает держать заряд, выключается при 20–30 %, заряжается медленно, греется. Это естественный процесс: литий-ионные батареи имеют ресурс около 500–800 циклов. Сервисный центр «Свой Мастер» в Екатеринбурге проводит замену аккумуляторов на телефонах любых брендов с гарантией до двух лет.</p><h3>Что включает ремонт</h3><p>Процедура начинается с бесплатной диагностики. Специалист подсоединяет устройство к тестеру, который показывает реальную емкость батареи и количество циклов. После согласования стоимости мастер приступает к работе:</p><ol><li><b>Вскрытие корпуса.</b> Телефон разбирается с задней крышки или с экрана. Используется нагревательная платформа для размягчения клея.</li><li><b>Отключение старой батареи.</b> Аккумулятор отсоединяется от контроллера питания. Применяются пластиковые инструменты, исключающие повреждение платы.</li><li><b>Установка новой батареи.</b> Монтируется аккумулятор, соответствующий заводским спецификациям. При необходимости наносится клеевой слой.</li><li><b>Сборка и тестирование.</b> Проверяется корректность отображения заряда, скорость зарядки, нагрев.</li></ol><p>Весь процесс занимает от 30 минут до полутора часов.</p><h3>Почему нам доверяют</h3><ul><li><b>Качественные аккумуляторы.</b> Используем батареи проверенных производителей. Прямые поставки исключают подделки.</li><li><b>Прозрачная цена.</b> Стоимость фиксируется в договоре до начала ремонта.</li><li><b>Ремонт в присутствии клиента.</b></li></ul><p>Для консультации и записи звоните нам. Ответим на все вопросы.</p>
HTML;

        $textDefectGlass = <<<'HTML'
<h2>Разбилось стекло на телефоне</h2><p>Треснувшее стекло — самая частая поломка смартфона. Если под поврежденным слоем дисплей продолжает показывать изображение, а сенсор по-прежнему реагирует на касания, менять дорогой экран в сборе не обязательно. Достаточно заменить только защитное стекло. Сервисный центр «Свой Мастер» в Екатеринбурге выполняет эту процедуру для телефонов любых брендов и моделей. Работаем с 2010 года.</p><h3>Почему не стоит клеить новое стекло самостоятельно</h3><p>В интернете много советов по самостоятельной замене стекла «на суперклей» или «двусторонний скотч». Это прямой путь к повреждению матрицы. Без профессионального оборудования — вакуумного стола и автоклава — под стеклом неизбежно останутся пузырьки воздуха, пыль и микроворсинки. Попавший внутрь клей намертво приклеит осколки к матрице, после чего качественный ремонт станет невозможным. В большинстве случаев такие эксперименты заканчиваются покупкой нового дисплейного модуля — а это в 2–3 раза дороже.</p><p>Если вовремя не заменить разбитое стекло, через трещины внутрь будет проникать пыль и влага. Со временем это может привести к повреждению самой матрицы или выходу из строя сенсорного слоя.</p><h3>Как происходит замена стекла в «Свой Мастер»</h3><p>Замена стекла — технологически сложный процесс, требующий специального оборудования. В нашем центре он выполняется поэтапно:</p><ol><li><b>Демонтаж дисплейного модуля.</b> Специалист аккуратно отсоединяет экран от корпуса с использованием нагревательных платформ для размягчения клея.</li><li><b>Отделение разбитого стекла.</b> Устройство фиксируется на вакуумном столе. Мастер с помощью специальной струны отделяет поврежденное стекло от оригинальной матрицы, работа ведется под микроскопом.</li><li><b>Очистка и обезжиривание.</b> Удаляются остатки старого клея и осколки, поверхность матрицы тщательно очищается.</li><li><b>Приклейка нового стекла.</b> В автоклаве новое стекло с заводским клеящим слоем соединяется с матрицей под давлением и температурой, что исключает пузырьки воздуха.</li><li><b>Сборка и тестирование.</b> Модуль устанавливается в корпус, проверяется работа сенсора, яркость, цветопередача, отсутствие засветов и пыли под стеклом.</li></ol><p>Операция занимает от 2 до 4 часов. Клиент может наблюдать за процессом в сервисе или забрать устройство в оговоренное время.</p><h3>Почему выбирают «Свой Мастер»</h3><ul><li><b>Бесплатная диагностика.</b> Мастер оценит возможность замены именно стекла и назовет окончательную стоимость до начала работ.</li><li><b>Экономия.</b> Замена стекла обходится в 2–3 раза дешевле, чем замена всего дисплейного модуля, при этом сохраняется оригинальная матрица.</li><li><b>Качественные материалы.</b> Используются стекла с заводским клеевым слоем, обеспечивающие прозрачность и полную чувствительность сенсора.</li><li><b>Честные условия.</b> Стоимость фиксируется в договоре, никаких доплат после ремонта.</li><li><b>Сохранность данных.</b> Устройство не подвергается перепрошивке, личная информация остается в безопасности.</li><li><b>Гарантия до двух лет.</b> На выполненные работы и установленное стекло.</li></ul><p><b>Важно!</b> Попытки самостоятельной замены без профессионального оборудования нередко заканчиваются повреждением матрицы, разрывом шлейфов или попаданием пыли и клея под стекло. Стоимость такой ошибки часто превышает цену качественного ремонта в сервисе.</p><p>Не откладывайте ремонт. Позвоните нам прямо сейчас: +7 (343) 226-46-22. Проконсультируем по стоимости и срокам для вашей модели.</p>
HTML;

        $textDefectNoCharge = <<<'HTML'
<h2>Телефон не заряжается</h2><p>Телефон перестал заряжаться или делает это только в определенном положении кабеля? Индикатор мигает, но процент не растет? Это признаки неисправности разъема зарядки, контроллера питания или аксессуаров. Сервисный центр «Свой Мастер» в Екатеринбурге выполнит диагностику и ремонт любой сложности с гарантией до двух лет.</p><h3>Почему смартфон перестал заряжаться</h3><p>Причин может быть несколько, и важно правильно определить источник проблемы:</p><ul><li><b>Засор разъема (USB-C, Lightning, Micro-USB).</b> Самая частая и простая в устранении причина. Пыль, ворсинки из карманов, мелкий мусор накапливаются в гнезде и мешают плотному контакту кабеля.</li><li><b>Механический износ разъема.</b> Ежедневные подключения постепенно расшатывают контакты. Частое использование неоригинальных кабелей ускоряет процесс, так как неподходящий штекер создает дополнительную нагрузку.</li><li><b>Проблемы с кабелем или блоком питания.</b> Внешне кабель может выглядеть исправно, но иметь внутренний обрыв. Наши специалисты проверят ваши аксессуары.</li><li><b>Выход из строя контроллера питания.</b> Это микросхема на материнской плате, которая управляет процессами зарядки и распределения энергии. Требует профессиональной микропайки.</li><li><b>Износ аккумулятора.</b> В редких случаях старый аккумулятор перестает принимать заряд. Обычно это сопровождается быстрой разрядкой.</li></ul><h3>Как происходит диагностика и ремонт</h3><p>Процесс начинается с бесплатной диагностики. Специалист проверяет разъем, кабель, блок питания, контроллер и аккумулятор, чтобы точно определить причину. После согласования стоимости мастер приступает к работе.</p><p>Этапы ремонта:</p><ol><li><b>Вскрытие устройства.</b> Смартфон аккуратно разбирается с использованием нагревательной платформы.</li><li><b>Чистка разъема.</b> При засоре мастер специальным инструментом удаляет мусор. Это самая быстрая и дешевая процедура.</li><li><b>Замена разъема.</b> При механическом износе поврежденный порт демонтируется. Выполняется аккуратная пайка нового разъема с соблюдением температурного режима, исключающего перегрев соседних компонентов на плате.</li><li><b>Ремонт контроллера питания.</b> В сложных случаях мастер перепаивает микросхемы или восстанавливает дорожки на плате.</li><li><b>Сборка и тестирование.</b> После ремонта проверяется зарядка, передача данных и работа в наушниках (если разъем совмещенный).</li></ol><p>Процесс занимает от 30 минут до 2 часов в зависимости от сложности. Клиент может наблюдать за работой в сервисе.</p><h3>Почему выбирают «Свой Мастер»</h3><ul><li><b>Качественные комплектующие.</b> Используем разъемы, соответствующие заводским спецификациям. Прямые поставки гарантируют совместимость и надежность.</li><li><b>Профессиональная пайка.</b> Специалисты имеют многолетний опыт работы с многослойными платами и микроэлектроникой.</li><li><b>Прозрачная цена.</b> Стоимость диагностики и ремонта фиксируется в договоре до начала работ. Никаких скрытых доплат.</li><li><b>Бесплатная диагностика.</b> Если вы передумаете ремонтироваться, диагностика все равно бесплатна.</li><li><b>Гарантия до двух лет.</b> На все виды работ и установленные компоненты.</li></ul><p>Не пользуйтесь телефоном с неработающей зарядкой — попытки зарядить его «вслепую» могут привести к полному разряду аккумулятора и выходу из строя контроллера питания. Для записи на ремонт звоните по контактному номеру: +7 (343) 226-46-22.</p>
HTML;

        $textDefectBatteryDrain = <<<'HTML'
<h2>Телефон быстро разряжается</h2><p>Смартфон перестал доживать до вечера, выключается при 20–30% заряда, греется или самопроизвольно перезагружается? Это классические признаки изношенного аккумулятора. Ресурс литий-ионной батареи составляет 500–800 циклов заряда-разряда, что соответствует 2–3 годам активного использования. Сервисный центр «Свой Мастер» в Екатеринбурге выполняет замену аккумуляторов на телефонах любых брендов с гарантией до двух лет.</p><h3>Почему батарея быстро разряжается</h3><p>Кроме естественного износа, быстрая разрядка может быть вызвана несколькими причинами:</p><ul><li><b>Износ аккумулятора.</b> Со временем химический состав батареи деградирует, реальная емкость снижается. Телефон показывает 100%, но фактически это лишь 60–70% от заводской емкости.</li><li><b>Программные сбои.</b> Фоновые процессы, вирусы или неудачное обновление могут заставлять процессор работать на максимальных частотах постоянно, быстро сажая батарею.</li><li><b>Повреждение контроллера питания.</b> Микросхема, отвечающая за распределение энергии, может выходить из строя, неправильно считывая остаток заряда или не отключая питание от неиспользуемых модулей.</li><li><b>Замыкание на плате.</b> Попадание влаги или повреждение компонентов может создать микро-замыкание, которое постоянно потребляет энергию.</li></ul><p>Наши специалисты проводят бесплатную диагностику, чтобы отличить программную проблему от аппаратной и предложить правильное решение.</p><h3>Как мы меняем аккумулятор</h3><p>Процедура начинается с бесплатной диагностики. Специалист подключает устройство к тестеру, который показывает реальную емкость батареи, количество циклов и напряжение. После согласования стоимости мастер приступает к работе:</p><ol><li><b>Вскрытие корпуса.</b> Телефон разбирается либо с задней крышки, либо со стороны экрана (в зависимости от модели). Используется нагревательная платформа для размягчения заводского клея.</li><li><b>Отключение старой батареи.</b> Аккумулятор отсоединяется от контроллера питания. Применяются пластиковые инструменты, исключающие повреждение материнской платы и шлейфов.</li><li><b>Удаление старого клея.</b> Посадочное место очищается от остатков клеевого слоя.</li><li><b>Установка новой батареи.</b> Монтируется аккумулятор, соответствующий заводским спецификациям по емкости, напряжению и габаритам. При необходимости наносится новый клеевой слой для фиксации.</li><li><b>Сборка и тестирование.</b> Корпус собирается. Проверяется корректность отображения процентов заряда, скорость зарядки, нагрев устройства под нагрузкой.</li></ol><p>Весь процесс занимает от 30 минут до полутора часов. Клиент может наблюдать за заменой в сервисе.</p><h3>Почему нам доверяют</h3><ul><li><b>Качественные аккумуляторы.</b> Используем батареи проверенных производителей, соответствующие заводским характеристикам. Прямые поставки исключают подделки и посреднические наценки.</li><li><b>Бесплатная диагностика.</b> Мастер определит точную причину быстрой разрядки и предложит оптимальное решение.</li><li><b>Прозрачная цена.</b> Стоимость аккумулятора и работы фиксируется в договоре до начала ремонта.</li><li><b>Сохранность данных.</b> Замена аккумулятора не затрагивает личную информацию — фотографии, документы, контакты остаются на месте.</li><li><b>Ремонт в присутствии клиента.</b> Вы можете наблюдать за процессом и убедиться в качестве используемых компонентов.</li><li><b>Гарантия до двух лет.</b> На установленный аккумулятор и выполненные работы.</li></ul><p>Запишитесь на замену аккумулятора по телефону: +7 (343) 226-46-22. Вернем телефону былую автономность. Назовите модель — мы сообщим точную стоимость замены аккумулятора.</p>
HTML;

        $textDefectWater = <<<'HTML'
<h2>В телефон попала вода</h2><p>Уронили телефон в воду, пролили на него кофе или чай, попали под дождь? Попадание влаги внутрь корпуса — одна из самых коварных поломок. Даже если устройство продолжает работать, жидкость запускает процесс коррозии контактов. С каждым днем риск необратимого повреждения материнской платы растет. Сервисный центр «Свой Мастер» в Екатеринбурге проведет экстренную ультразвуковую очистку и профессиональное восстановление после залития.</p><h3>Что происходит с телефоном при попадании влаги</h3><p>Вода или другая жидкость проникает внутрь корпуса через разъемы, динамики, кнопки и микрощели. Даже если у смартфона есть влагозащита по стандарту IP67 или IP68, гарантии полной герметичности нет — со временем уплотнители изнашиваются.</p><p>Жидкость вызывает электрохимическую коррозию. Контакты окисляются, между дорожками на плате возникают короткие замыкания, микросхемы выходят из строя. Первые признаки могут появиться не сразу, а через несколько дней или недель:</p><ul><li>перестает работать сенсор</li><li>пропадает звук или микрофон</li><li>телефон самопроизвольно перезагружается</li><li>быстро разряжается или греется</li><li>устройство вовсе перестает включаться</li></ul><p>Промедление увеличивает риск необратимых повреждений. Чем раньше вы обратитесь в сервис, тем выше шанс спасти телефон без замены дорогостоящих компонентов.</p><h3>Срочные действия: что делать и чего делать нельзя</h3><p><b>Правильно:</b></p><ul><li>Немедленно выключите телефон (если он еще работает)</li><li>Не пытайтесь его заряжать</li><li>Как можно скорее отнесите в сервисный центр</li></ul><p><b>НЕЛЬЗЯ:</b></p><ul><li>Сушить феном — горячий воздух испаряет воду, но ускоряет коррозию</li><li>Класть на батарею или микроволновку — перегрев повредит аккумулятор и плату</li><li>Класть в рис — это бесполезно и забивает разъемы крахмалом</li><li>Включать для проверки — короткое замыкание может окончательно убить материнскую плату</li></ul><h3>Как мы восстанавливаем телефон после залития</h3><p>Наши специалисты проводят полную диагностику для оценки масштаба повреждений. Работы выполняются поэтапно, каждый этап согласовывается с клиентом:</p><ol><li><b>Полная разборка устройства.</b> Смартфон аккуратно вскрывается с соблюдением заводских рекомендаций. Демонтируются материнская плата, дисплей, аккумулятор, камеры, шлейфы и все компоненты, подвергшиеся воздействию жидкости.</li><li><b>Ультразвуковая очистка.</b> Материнская плата и мелкие компоненты помещаются в ультразвуковую ванну с профессиональным раствором. Высокочастотные колебания удаляют окислы, соль, грязь даже из-под микросхем.</li><li><b>Сушка и дефектовка.</b> Компоненты тщательно просушиваются. Специалист проверяет целостность дорожек, контактных площадок и микросхем под микроскопом.</li><li><b>Замена поврежденных деталей.</b> Если какие-то элементы восстановить невозможно, мастер предлагает замену (разъемы, фильтры, стабилизаторы, контроллеры). Стоимость согласовывается заранее.</li><li><b>Сборка и тестирование.</b> Устройство собирается. Проверяются все функции: звонки, камера, Wi-Fi, Bluetooth, сенсор, динамики, микрофон, зарядка.</li></ol><p>При нецелесообразности ремонта (если стоимость восстановления превышает цену устройства) мастер честно сообщит об этом и предложит оптимальное решение.</p><h3>Почему выбирают «Свой Мастер»</h3><ul><li><b>Бесплатная диагностика.</b> Специалист оценит состояние аппарата и назовет стоимость ремонта без предоплаты.</li><li><b>Профессиональное оборудование.</b> Ультразвуковая чистка, микроскоп, нагревательные платформы — все необходимое для качественного восстановления.</li><li><b>Прозрачные условия.</b> Договор фиксирует стоимость и перечень работ до начала ремонта. Никаких «сюрпризов» после.</li><li><b>Качественные комплектующие.</b> Заменяемые детали соответствуют техническим требованиям и проходят входной контроль.</li><li><b>Гарантия до двух лет.</b> На выполненные работы и установленные компоненты.</li><li><b>Конфиденциальность.</b> Личные данные на устройстве не передаются третьим лицам.</li></ul><p><b>Важно!</b> Даже если телефон проработал несколько дней после залития и «высох», это не означает, что коррозия остановилась. Без профессиональной очистки процесс разрушения контактов продолжится.</p><p>Дорога каждая минута. Свяжитесь с нами сразу: +7 (343) 226-46-22. Проведем экстренную ультразвуковую очистку.</p>
HTML;

        $textDefectNoSignal = <<<'HTML'
<h2>Телефон не ловит сеть</h2><p>Телефон перестал ловить сеть, не видит оператора, пишет «Нет сети» или «Только экстренные вызовы»? Проблема может быть как в программном сбое, так и в аппаратной неисправности антенны или радиомодуля. Сервисный центр «Свой Мастер» в Екатеринбурге проведет диагностику и восстановит работу сотовой связи на телефонах любых брендов.</p><h3>Почему телефон не ловит сеть</h3><p>Причин отсутствия сети несколько, и важно правильно определить источник проблемы:</p><ul><li><b>Программный сбой.</b> После неудачного обновления, установки «кривого» приложения или вирусного заражения радиомодуль может работать некорректно.</li><li><b>Проблемы с SIM-картой.</b> Поврежденная или старая SIM-карта часто становится причиной. Мы проверим вашу карту в другом телефоне.</li><li><b>Неисправность антенны.</b> Внутренняя антенна смартфона может повредиться после падения или удара. Контактный шлейф отходит от платы.</li><li><b>Выход из строя радиомодуля.</b> Это микросхема на материнской плате, отвечающая за прием и передачу сигнала. Требует профессиональной микропайки.</li><li><b>Последствия залития.</b> Влага вызывает коррозию контактов антенны и радиомодуля.</li></ul><h3>Как мы восстанавливаем сеть</h3><p>Процесс начинается с бесплатной диагностики. Специалист проверяет SIM-карту, программную часть, антенну и радиомодуль. После согласования стоимости мастер приступает к работе:</p><ol><li><b>Программная диагностика.</b> Мастер проверяет настройки сети, IMEI и регистрацию в сети оператора.</li><li><b>Перепрошивка.</b> При программном сбое выполняется восстановление через лицензионное ПО с сохранением данных (при возможности).</li><li><b>Вскрытие устройства.</b> Если проблема аппаратная, смартфон аккуратно разбирается.</li><li><b>Ремонт антенны.</b> Восстанавливается контакт антенного шлейфа или заменяется поврежденный элемент.</li><li><b>Ремонт радиомодуля.</b> При выходе модуля из строя выполняется микропайка на материнской плате.</li><li><b>Сборка и тестирование.</b> Проверяется поиск сети, прием и передача вызовов, мобильный интернет.</li></ol><h3>Почему выбирают «Свой Мастер»</h3><ul><li><b>Бесплатная диагностика.</b> Мастер определит причину и назовет стоимость до начала работ.</li><li><b>Профессиональная пайка.</b> Специалисты имеют опыт работы с многослойными платами и радиомодулями.</li><li><b>Прозрачная цена.</b> Стоимость фиксируется в договоре, никаких доплат после ремонта.</li><li><b>Качественные комплектующие.</b> Используем антенны и шлейфы, соответствующие заводским спецификациям.</li><li><b>Гарантия до двух лет.</b> На все виды работ и установленные компоненты.</li></ul><p>Не откладывайте ремонт. Без сети телефон теряет свои основные функции. Звоните для записи на диагностику: +7 (343) 226-46-22.</p>
HTML;

        $textDefectNoWifi = <<<'HTML'
<h2>Телефон не подключается к Wi-Fi</h2><p>Телефон перестал видеть Wi-Fi сети, не подключается к роутеру или постоянно теряет соединение? Возможно, после подключения пишет «Ошибка аутентификации» или «Сохранено, но не подключается»? Проблема может быть как в программном сбое, так и в аппаратной неисправности Wi-Fi модуля. Сервисный центр «Свой Мастер» восстановит беспроводную связь на телефонах любых брендов.</p><h3>Почему Wi-Fi перестал работать</h3><p>Основные причины неисправности:</p><ul><li><b>Программный сбой.</b> После обновления системы, установки приложений или вирусного заражения настройки сети могут «слететь».</li><li><b>Ошибки роутера.</b> Не спешите ремонтировать телефон — проблема может быть в вашем домашнем Wi-Fi. Мы проверим это на диагностике.</li><li><b>Неисправность антенны Wi-Fi.</b> Внутренняя антенна повреждается после падения или удара. Контакт отходит от материнской платы.</li><li><b>Выход из строя Wi-Fi модуля.</b> Это микросхема, интегрированная в материнскую плату (часто объединена с Bluetooth). Требует микропайки или замены.</li><li><b>Последствия залития.</b> Коррозия контактов и дорожек, отвечающих за беспроводную связь.</li></ul><h3>Как мы ремонтируем Wi-Fi</h3><p>Процесс начинается с бесплатной диагностики. Специалист проверит работу модуля, антенны и программной части. После согласования стоимости мастер приступает к работе:</p><ol><li><b>Программное восстановление.</b> Сброс сетевых настроек, проверка конфигураций, при необходимости — перепрошивка с сохранением данных.</li><li><b>Проверка роутера.</b> Подключаем телефон к разным точкам доступа, чтобы исключить проблему на стороне клиента.</li><li><b>Вскрытие устройства.</b> Если проблема аппаратная, смартфон аккуратно разбирается.</li><li><b>Ремонт антенны.</b> Восстанавливается контакт или заменяется антенный шлейф.</li><li><b>Ремонт Wi-Fi модуля.</b> Выполняется микропайка или замена микросхемы на материнской плате.</li><li><b>Сборка и тестирование.</b> Проверяется поиск сетей, скорость соединения, работа Bluetooth.</li></ol><h3>Почему нам доверяют</h3><ul><li><b>Бесплатная диагностика.</b> Вы узнаете причину и стоимость до начала ремонта.</li><li><b>Профессиональное оборудование.</b> Микропайка выполняется на станциях с контролем температуры.</li><li><b>Прозрачная цена.</b> Стоимость фиксируется в договоре.</li><li><b>Гарантия до двух лет.</b> На работы и установленные компоненты.</li><li><b>Сохранность данных.</b> При программном восстановлении информация не затрагивается.</li></ul><p>Для записи на ремонт звоните по контактному номеру: +7 (343) 226-46-22.</p>
HTML;

        $textDefectNoCamera = <<<'HTML'
<h2>Не работает камера на телефоне</h2><p>Черный экран при запуске камеры, размытые снимки, отсутствие фокусировки, темные пятна на фото или дрожание изображения — признаки выхода из строя основного или фронтального модуля. Сервисный центр «Свой Мастер» выполняет замену камер на телефонах любых брендов. Работаем с 2010 года, гарантируем полное восстановление качества съемки.</p><h3>Почему камера выходит из строя</h3><p>Самые частые причины — механические удары и падения. Даже при внешней целостности корпуса внутренние компоненты модуля могут сместиться или разрушиться. Попадание пыли и влаги через микротрещины также ухудшает качество снимков. В некоторых случаях проблема в шлейфе, соединяющем модуль с платой, или в контроллере питания камеры.</p><p>Отдельная категория — выход из строя оптического стабилизатора. Изображение начинает «дергаться», особенно при съемке видео. Модуль подлежит полной замене: ремонт стабилизатора в условиях сервиса, как правило, экономически нецелесообразен.</p><h3>Как мы меняем камеру</h3><p>Процесс начинается с бесплатной диагностики. Специалист проверяет работу модулей, определяет характер неисправности. После согласования стоимости мастер приступает к работе.</p><p>Смартфон аккуратно вскрывается с использованием нагревательной платформы. Доступ к камере осуществляется через заднюю крышку или со стороны дисплея. Поврежденный модуль демонтируется, контакты очищаются. Устанавливается новая камера, соответствующая заводским спецификациям. После сборки проводится тестирование: фокусировка, вспышка, запись видео, переключение между объективами. Клиент может наблюдать за процессом в сервисе.</p><h3>Преимущества обращения в «Свой Мастер»</h3><ul><li><b>Качественные комплектующие.</b> Используем камеры, соответствующие оригинальным характеристикам. Прямые поставки исключают подделки.</li><li><b>Бесплатная диагностика.</b> Оценка состояния без предоплаты.</li><li><b>Прозрачная цена.</b> Стоимость фиксируется в договоре до начала работ.</li><li><b>Сохранность данных.</b> Замена камеры не затрагивает личную информацию.</li><li><b>Гарантия до двух лет.</b> На установленный модуль и выполненные работы.</li></ul><p>Хотите вернуть четкие фото? Звоните: +7 (343) 226-46-22. Подберем оригинальную камеру под вашу модель.</p>
HTML;

        $textDefectNoSound = <<<'HTML'
<h2>Нет звука на телефоне</h2><p>Нет звука в динамике, собеседника плохо слышно в разговоре, музыка играет с хрипами или шумами? Возможно, перестал работать разговорный динамик, мультимедийный динамик или аудиокодек. Сервисный центр «Свой Мастер» выполнит диагностику и ремонт звуковой части на телефонах любых брендов.</p><h3>Почему пропадает звук</h3><p>Причин отсутствия звука несколько:</p><ul><li><b>Засор защитной сетки.</b> Пыль и мелкий мусор забивают отверстие динамика, звук становится тихим или пропадает полностью.</li><li><b>Попадание влаги.</b> Жидкость вызывает короткое замыкание и коррозию контактов динамика.</li><li><b>Механическое повреждение.</b> После удара динамик может отойти от контактной группы или разрушиться.</li><li><b>Неисправность аудиокодека.</b> Это микросхема на материнской плате, отвечающая за обработку звука. Требует микропайки.</li><li><b>Программный сбой.</b> Вирусное заражение или неудачное обновление может отключить звук на уровне ПО.</li></ul><h3>Как мы восстанавливаем звук</h3><p>Процесс начинается с бесплатной диагностики. Специалист определяет, какой именно динамик не работает (разговорный или мультимедийный) и в чем причина. После согласования стоимости мастер приступает к работе:</p><ol><li><b>Чистка сетки динамика.</b> При засоре мастер аккуратно очищает отверстие специальным инструментом без разбора телефона.</li><li><b>Программная диагностика.</b> Проверяются настройки звука, при необходимости выполняется перепрошивка.</li><li><b>Вскрытие устройства.</b> Если проблема аппаратная, смартфон разбирается.</li><li><b>Замена динамика.</b> Поврежденный элемент демонтируется, устанавливается новый, соответствующий заводским спецификациям.</li><li><b>Ремонт аудиокодека.</b> При выходе микросхемы из строя выполняется микропайка на материнской плате.</li><li><b>Сборка и тестирование.</b> Проверяется громкость звонка, качество речи собеседника, воспроизведение музыки.</li></ol><h3>Почему выбирают «Свой Мастер»</h3><ul><li><b>Бесплатная диагностика.</b> Вы узнаете причину и стоимость до ремонта.</li><li><b>Качественные комплектующие.</b> Используем динамики, соответствующие техническим требованиям.</li><li><b>Прозрачная цена.</b> Стоимость фиксируется в договоре.</li><li><b>Профессиональная пайка.</b> Специалисты имеют опыт работы с аудиокодеками на многослойных платах.</li><li><b>Гарантия до двух лет.</b> На работы и установленные компоненты.</li></ul><p>Не слышно собеседника? Позвоните: +7 (343) 226-46-22. Диагностика бесплатно.</p>
HTML;

        $textDefectNoPower = <<<'HTML'
<h2>Телефон не включается</h2><p>Смартфон перестал реагировать на кнопку включения, не заряжается или завис на черном экране? Причин может быть несколько — от разряженного аккумулятора до серьезного повреждения материнской платы. Сервисный центр «Свой Мастер» проведет диагностику и восстановит работоспособность телефонов любых брендов.</p><h3>Почему телефон не включается</h3><p>Причины могут быть программными или аппаратными:</p><ul><li><b>Полный разряд аккумулятора.</b> Батарея ушла в глубокий разряд и не принимает заряд от стандартного зарядного устройства.</li><li><b>Неисправность кнопки включения.</b> Западает или не срабатывает механический элемент, шлейф кнопки поврежден.</li><li><b>Выход из строя контроллера питания.</b> Микросхема на материнской плате перестала распределять питание.</li><li><b>Повреждение материнской платы.</b> После падения, удара или залития могли повредиться дорожки или микросхемы.</li><li><b>Программный сбой.</b> Система «упала» после неудачного обновления или установки вируса, телефон завис в цикле загрузки.</li></ul><h3>Как мы восстанавливаем включение</h3><p>Процесс начинается с бесплатной диагностики. Специалист проверяет аккумулятор, контроллер питания, кнопку включения и программную часть. После согласования стоимости мастер приступает к работе:</p><ol><li><b>Зарядка аккумулятора напрямую.</b> При глубоком разряде батарея заряжается через специальное оборудование в обход контроллера.</li><li><b>Замена кнопки включения.</b> При механической неисправности выполняется замена шлейфа или самой кнопки.</li><li><b>Ремонт контроллера питания.</b> Выполняется микропайка на материнской плате, замена вышедших из строя микросхем.</li><li><b>Программное восстановление.</b> Перепрошивка через лицензионное ПО, сброс настроек до заводских.</li><li><b>Ремонт материнской платы.</b> Восстановление дорожек, замена микроконтроллеров, устранение последствий залития.</li></ol><p>Сложные работы занимают от 1 до 3 часов. Клиент информируется о каждом этапе.</p><h3>Преимущества обращения в «Свой Мастер»</h3><ul><li><b>Бесплатная диагностика.</b> Мастер определит причину и назовет стоимость до начала работ.</li><li><b>Профессиональное оборудование.</b> Станции для микропайки, программаторы, источники питания.</li><li><b>Прозрачная цена.</b> Стоимость фиксируется в договоре, никаких доплат после ремонта.</li><li><b>Качественные комплектующие.</b> Используем оригинальные детали или лицензированные аналоги.</li><li><b>Гарантия до двух лет.</b> На все виды работ и установленные компоненты.</li></ul><p>Не пытайтесь самостоятельно разбирать телефон, если он не включается. Неправильные действия могут окончательно повредить материнскую плату. Звоните для записи на диагностику: +7 (343) 226-46-22.</p>
HTML;

        $textDefectSlow = <<<'HTML'
<h2>Телефон тормозит и зависает</h2><p>Телефон стал медленно работать, приложения открываются с задержкой, интерфейс «залипает», а клавиатура едва успевает за вашими пальцами? Это признаки программных проблем или износа памяти. Сервисный центр «Свой Мастер» проведет оптимизацию и восстановит быстродействие телефонов любых брендов.</p><h3>Почему смартфон тормозит</h3><p>Основные причины снижения производительности:</p><ul><li><b>Переполненная память.</b> Осталось менее 10-15% свободного места — система начинает «задыхаться», кэширование работает некорректно.</li><li><b>Фоновые процессы.</b> Множество приложений работают в фоне, потребляя оперативную память и процессорное время.</li><li><b>Устаревшее или «кривое» ПО.</b> Старые версии Android или iOS не оптимизированы, обновления могут содержать ошибки.</li><li><b>Вирусное заражение.</b> Вредоносные программы майнят криптовалюту или накручивают рекламу, загружая процессор.</li><li><b>Деградация памяти.</b> У флеш-памяти (eMMC/UFS) есть ресурс записи. Со временем скорость чтения и записи падает.</li><li><b>Перегрев.</b> При длительной нагрузке процессор сбрасывает частоты, чтобы не перегреться — производительность падает.</li></ul><h3>Как мы восстанавливаем быстродействие</h3><p>Процесс начинается с бесплатной диагностики. Специалист оценивает загрузку процессора, состояние памяти, температуру и программную среду. После согласования стоимости мастер приступает к работе:</p><ol><li><b>Очистка системы.</b> Удаление мусора, кэша, неиспользуемых приложений и дубликатов файлов.</li><li><b>Оптимизация автозагрузки.</b> Отключение фоновых процессов, которые не нужны пользователю.</li><li><b>Удаление вирусов.</b> Сканирование и лечение вредоносного ПО.</li><li><b>Сброс до заводских настроек.</b> Крайняя мера при программных сбоях, которые не лечатся иначе. Данные сохраняются в резервную копию (при возможности).</li><li><b>Замена аккумулятора.</b> В редких случаях тормоза вызваны тем, что старый аккумулятор не выдает нужный ток, и процессор сбрасывает частоты.</li><li><b>Обновление ПО.</b> Установка актуальной и стабильной версии прошивки.</li></ol><h3>Почему выбирают «Свой Мастер»</h3><ul><li><b>Бесплатная диагностика.</b> Узнаете причину тормозов без оплаты.</li><li><b>Сохранность данных.</b> При сбросе настроек мы создаем резервную копию (если это возможно).</li><li><b>Прозрачная цена.</b> Стоимость оптимизации фиксируется в договоре.</li><li><b>Безопасность.</b> Используем лицензионное ПО, исключаем утечку личной информации.</li><li><b>Гарантия на работы.</b> При сохранении проблемы после оптимизации — повторная настройка бесплатно.</li></ul><p>Звоните +7 (343) 226-46-22, чтобы записаться на диагностику. Большинство проблем с производительностью решается за 1-2 часа.</p>
HTML;

        $textDefectSensor = <<<'HTML'
<h2>Не работает сенсор на телефоне</h2><p>Дисплей не реагирует на касания, срабатывает самопроизвольно, нажимает не туда или перестал распознавать свайпы? Это признаки неисправности сенсорного слоя (тачскрина). Сервисный центр «Свой Мастер» выполнит замену стекла с сенсором или полную замену дисплейного модуля на телефонах любых брендов.</p><h3>Почему сенсор глючит</h3><p>Причин некорректной работы тачскрина несколько:</p><ul><li><b>Повреждение сенсорного слоя.</b> После удара, падения или сильного нажатия сенсорная сетка внутри стекла может нарушиться.</li><li><b>Засор по краям экрана.</b> Грязь, пыль или остатки клея под защитным стеклом создают ложные нажатия.</li><li><b>Плохое защитное стекло.</b> Некачественная пленка или стекло могут мешать прохождению электрических импульсов от пальца.</li><li><b>Последствия залития.</b> Влага вызывает коррозию контактов шлейфа сенсора на материнской плате.</li><li><b>Проблемы с прошивкой.</b> В редких случаях сенсор «глючит» из-за программного сбоя (например, после обновления).</li></ul><h3>Как мы ремонтируем сенсор</h3><p>Процесс начинается с бесплатной диагностики. Специалист проверяет, поврежден ли сенсорный слой или проблема в шлейфе/контроллере. После согласования стоимости мастер приступает к работе:</p><ol><li><b>Проверка защитного стекла.</b> Снимаем некачественную пленку или стекло, проверяем работу сенсора без них.</li><li><b>Программная диагностика.</b> Исключаем программный сбой через сброс или перепрошивку.</li><li><b>Вскрытие устройства.</b> Смартфон аккуратно разбирается.</li><li><b>Очистка контактов шлейфа.</b> Если проблема в окислении — контакты зачищаются и обрабатываются.</li><li><b>Замена сенсорного стекла.</b> При повреждении сенсорного слоя выполняется замена стекла с сенсором (если модель позволяет).</li><li><b>Замена дисплейного модуля.</b> Если сенсор интегрирован в матрицу и не заменяется отдельно — устанавливается новый модуль в сборе.</li></ol><p><i>Важно: на многих современных телефонах сенсор и матрица представляют собой единое целое (OLED-дисплеи). В таких случаях отдельная замена сенсора невозможна, требуется полная замена модуля.</i></p><h3>Преимущества обращения в «Свой Мастер»</h3><ul><li><b>Бесплатная диагностика.</b> Мастер определит, что именно сломалось: сенсор, шлейф или контроллер.</li><li><b>Честная консультация.</b> Если сенсор меняется только в сборе с матрицей — мы предупредим об этом до начала работ.</li><li><b>Качественные комплектующие.</b> Оригинальные дисплейные модули или лицензированные аналоги.</li><li><b>Прозрачная цена.</b> Стоимость фиксируется в договоре.</li><li><b>Гарантия до двух лет.</b> На выполненные работы и установленные компоненты.</li></ul><p>Пользоваться телефоном с глючащим сенсором практически невозможно. Не откладывайте ремонт. Звоните для записи: +7 (343) 226-46-22.</p>
HTML;

        $textDefectPowerButton = <<<'HTML'
<h2>Не работает кнопка включения</h2><p>Кнопка питания перестала нажиматься, западает, срабатывает через раз или телефон самопроизвольно перезагружается? Это признаки износа механического элемента или повреждения шлейфа. Сервисный центр «Свой Мастер» выполнит замену кнопки включения на телефонах любых брендов с гарантией до двух лет.</p><h3>Почему кнопка включения выходит из строя</h3><p>Основные причины неисправности:</p><ul><li><b>Механический износ.</b> Кнопка рассчитана на тысячи нажатий. Со временем контактная группа истирается или окисляется.</li><li><b>Западание после удара.</b> Падение может сместить внутренний толкатель или деформировать корпус вокруг кнопки.</li><li><b>Засор.</b> Пыль, грязь, остатки клея или высохшей жидкости блокируют ход кнопки.</li><li><b>Повреждение шлейфа кнопки.</b> Внутренний шлейф, соединяющий кнопку с материнской платой, мог перетереться или разорваться.</li><li><b>Проблемы с контроллером питания.</b> В редких случаях кнопка исправна, но микросхема на плате перестала реагировать на сигнал.</li></ul><h3>Как мы меняем кнопку включения</h3><p>Процесс начинается с бесплатной диагностики. Специалист определяет, в чем именно проблема: засор, износ самого тактового элемента или повреждение шлейфа. После согласования стоимости мастер приступает к работе:</p><ol><li><b>Вскрытие устройства.</b> Смартфон аккуратно разбирается с использованием нагревательной платформы.</li><li><b>Очистка кнопки.</b> При засоре мастер удаляет грязь без замены деталей.</li><li><b>Замена тактового элемента.</b> Поврежденный микропереключатель выпаивается, устанавливается новый.</li><li><b>Замена шлейфа кнопки.</b> Если поврежден шлейф — выполняется его демонтаж и установка нового.</li><li><b>Ремонт контроллера.</b> При проблемах на материнской плате выполняется микропайка.</li><li><b>Сборка и тестирование.</b> Проверяется работа кнопки: включение, блокировка, вызов меню (в зависимости от модели).</li></ol><p>Операция занимает от 30 минут до полутора часов. Клиент может наблюдать за процессом в сервисе.</p><h3>Почему выбирают «Свой Мастер»</h3><ul><li><b>Бесплатная диагностика.</b> Узнаете причину и стоимость до ремонта.</li><li><b>Профессиональная пайка.</b> Работа с микроэлектроникой, исключающая перегрев соседних компонентов.</li><li><b>Качественные комплектующие.</b> Оригинальные тактовые элементы и шлейфы, соответствующие заводским спецификациям.</li><li><b>Прозрачная цена.</b> Стоимость фиксируется в договоре.</li><li><b>Гарантия до двух лет.</b> На установленные детали и выполненные работы.</li></ul><p>Не игнорируйте проблему. Западающая или неработающая кнопка включения может полностью заблокировать доступ к телефону. Звоните для записи: +7 (343) 226-46-22.</p>
HTML;

        $textDefectNoSim = <<<'HTML'
<h2>Телефон не видит SIM-карту</h2><p>Телефон пишет «Нет SIM-карты», «Вставьте SIM-карту» или «Не зарегистрирован в сети»? Причина может быть как в самой карте, так и в аппаратной части смартфона. Сервисный центр «Свой Мастер» восстановит работу SIM-картоприемника на телефонах любых брендов.</p><h3>Почему телефон не видит SIM-карту</h3><p>Причин может быть несколько, от простых до сложных:</p><ul><li><b>Повреждение SIM-карты.</b> Карта могла перетереться, сломаться или прийти в негодность от времени. Мы проверим вашу карту в другом телефоне.</li><li><b>Засор слота SIM-карты.</b> Пыль, ворсинки или мелкий мусор мешают контакту карты с пинами.</li><li><b>Окисление контактов.</b> Попадание влаги внутрь слота вызывает коррозию, контакты перестают проводить сигнал.</li><li><b>Повреждение шлейфа или платы с SIM-слотом.</b> После падения или неаккуратной замены карты могли повредиться контакты на плате.</li><li><b>Программный сбой.</b> После обновления или вирусного заражения радиомодуль может не видеть SIM-карту.</li><li><b>Неисправность контроллера SIM-карты.</b> Микросхема на материнской плате, отвечающая за связь с картой, вышла из строя.</li></ul><h3>Как мы ремонтируем</h3><p>Процесс начинается с бесплатной диагностики. Специалист проверяет SIM-карту, слот, шлейф, контроллер и программную часть. После согласования стоимости мастер приступает к работе:</p><ol><li><b>Проверка SIM-карты.</b> Карта тестируется в другом телефоне. При неисправности мастер порекомендует заменить ее у оператора.</li><li><b>Чистка слота.</b> Специальным инструментом удаляется пыль и мусор из SIM-лотка.</li><li><b>Очистка контактов.</b> При окислении контакты зачищаются и обрабатываются антикоррозийным составом.</li><li><b>Замена шлейфа или SIM-слота.</b> Поврежденный элемент демонтируется, устанавливается новый.</li><li><b>Программное восстановление.</b> Сброс сетевых настроек, перепрошивка при необходимости.</li><li><b>Ремонт контроллера.</b> Выполняется микропайка на материнской плате.</li></ol><h3>Преимущества обращения в «Свой Мастер»</h3><ul><li><b>Бесплатная диагностика.</b> Мы определим точную причину без оплаты.</li><li><b>Прозрачная цена.</b> Стоимость ремонта фиксируется в договоре.</li><li><b>Качественные комплектующие.</b> Оригинальные шлейфы и SIM-слоты под вашу модель.</li><li><b>Профессиональная пайка.</b> Восстановление контроллера на многослойной плате.</li><li><b>Гарантия до двух лет.</b> На все виды работ и установленные компоненты.</li></ul><p>Звоните для записи на диагностику: +7 (343) 226-46-22. В большинстве случаев проблема решается за 30-60 минут.</p>
HTML;

        $textDefectFaceId = <<<'HTML'
<h2>Не работает Face ID на телефоне</h2><p>Система распознавания лица перестала работать, пишет «Face ID недоступна» или не узнает владельца? Это серьезная аппаратная проблема, особенно на устройствах iPhone. Сервисный центр «Свой Мастер» выполнит диагностику и ремонт Face ID на смартфонах с сохранением функциональности системы.</p><h3>Почему Face ID перестает работать</h3><p>Face ID — сложная система, состоящая из нескольких компонентов:</p><ul><li><b>Повреждение фронтальной камеры.</b> Модуль TrueDepth (проектор точек, инфракрасная камера, датчик приближения) может выйти из строя после удара или залития.</li><li><b>Замена дисплея без переноса чипа.</b> На iPhone 13 и новее замена экрана без переноса оригинального чипа приводит к отключению Face ID.</li><li><b>Замена задней крышки без осторожности.</b> Повреждение шлейфов, соединяющих модуль TrueDepth с материнской платой.</li><li><b>Программный сбой.</b> После обновления iOS или сброса настроек система распознавания может временно отключиться.</li><li><b>Засор области фронтальной камеры.</b> Грязь или пыль на защитном стекле могут мешать работе инфракрасных датчиков.</li><li><b>Неисправность материнской платы.</b> Повреждение дорожек или микросхем, отвечающих за обработку данных с Face ID.</li></ul><h3>Как мы восстанавливаем Face ID</h3><p>Процесс начинается с бесплатной диагностики. Специалист проверяет все компоненты системы и определяет, какой именно элемент неисправен. После согласования стоимости мастер приступает к работе:</p><ol><li><b>Программная диагностика.</b> Проверка версии iOS, сброс настроек Face ID и повторная настройка.</li><li><b>Чистка области датчиков.</b> Аккуратное удаление загрязнений с защитного стекла над модулем.</li><li><b>Вскрытие устройства.</b> Смартфон аккуратно разбирается с использованием нагревательной платформы.</li><li><b>Диагностика модуля TrueDepth.</b> Проверка проектора точек, инфракрасной камеры и датчика приближения.</li><li><b>Замена компонентов.</b> При повреждении отдельных элементов — замена с сохранением оригинальных микросхем (требуется микропайка и перепрограммирование).</li><li><b>Восстановление после замены дисплея.</b> Если Face ID отключился после смены экрана, требуется перенос чипа или перепрошивка модуля.</li><li><b>Сборка и тестирование.</b> Проверяется работа распознавания лица в разных условиях.</li></ol><p><i>Важно: На большинстве смартфонов (особенно iPhone) Face ID привязана к материнской плате и отдельным микросхемам. Простая замена модуля без перепрограммирования не восстановит работу. Наши специалисты владеют технологией ремонта с сохранением оригинальных компонентов.</i></p><h3>Преимущества обращения в «Свой Мастер»</h3><ul><li><b>Бесплатная диагностика.</b> Узнаете причину и возможность ремонта.</li><li><b>Честная консультация.</b> Если восстановить Face ID невозможно (например, после серьезного повреждения платы), мастер сообщит об этом до начала работ.</li><li><b>Микропайка.</b> Высококвалифицированные специалисты с опытом ремонта сложных систем.</li><li><b>Прозрачная цена.</b> Стоимость фиксируется в договоре.</li><li><b>Гарантия.</b> На работы по восстановлению Face ID.</li></ul><p>Face ID недоступен? Свяжитесь с нами: +7 (343) 226-46-22. Диагностика бесплатно. Работаем со сложными модулями.</p>
HTML;

        $textDefectFingerprint = <<<'HTML'
<h2>Не работает сканер отпечатка на телефоне</h2><p>Сканер отпечатка перестал распознавать палец, не реагирует на прикосновение или исчез из настроек телефона? Это частая проблема после замены дисплея, попадания влаги или механического повреждения. Сервисный центр «Свой Мастер» выполнит ремонт или замену сканера отпечатка на телефонах любых брендов.</p><h3>Почему сканер отпечатка не работает</h3><p>Сканеры отпечатков бывают трех типов, и у каждого свои причины поломок:</p><ul><li><b>Емкостный сканер (в кнопке Home или на задней крышке):</b> Износ или повреждение кнопки после падения, засор или окисление контактов, повреждение шлейфа.</li><li><b>Оптический сканер (под экраном, чаще на Android):</b> Повреждение дисплейного модуля, загрязнение или царапины на защитном стекле над областью сканера, программный сбой.</li><li><b>Ультразвуковой сканер (под экраном, Samsung и др.):</b> Повреждение дисплея, несовместимость после замены стекла или дисплея неоригинальной деталью.</li></ul><h3>Как мы ремонтируем сканер отпечатка</h3><p>Процесс начинается с бесплатной диагностики. Специалист определяет тип сканера, причину неисправности и возможность ремонта. После согласования стоимости мастер приступает к работе:</p><ol><li><b>Программная диагностика.</b> Удаление старых отпечатков, перенастройка, проверка наличия сканера в системе.</li><li><b>Чистка области сканера.</b> При оптическом и ультразвуковом сканере — удаление загрязнений с экрана.</li><li><b>Вскрытие устройства.</b> При необходимости смартфон аккуратно разбирается.</li><li><b>Проверка шлейфа и контактов.</b> Очистка или восстановление контактной группы сканера.</li><li><b>Замена сканера.</b> При повреждении — замена компонента. На подэкранных сканерах обычно требуется замена дисплейного модуля в сборе.</li><li><b>Калибровка.</b> После замены выполняется калибровка сканера через инженерное меню.</li><li><b>Сборка и тестирование.</b> Проверяется скорость и точность распознавания.</li></ol><h3>Почему выбирают «Свой Мастер»</h3><ul><li><b>Бесплатная диагностика.</b> Определим причину и возможность ремонта.</li><li><b>Честная консультация.</b> Если сканер не восстанавливается (например, привязан к материнской плате), мастер сообщит об этом.</li><li><b>Качественные комплектующие.</b> Оригинальные сканеры и дисплейные модули.</li><li><b>Калибровка после ремонта.</b> Обеспечиваем корректную работу сканера.</li><li><b>Прозрачная цена.</b> Стоимость фиксируется в договоре.</li><li><b>Гарантия до двух лет.</b> На установленные компоненты и работы.</li></ul><p>Сканер отпечатка не узнает палец? Звоните: +7 (343) 226-46-22. После ремонта проведем калибровку.</p>
HTML;

        // Категории — оставляем в поле seo_bottom_text на самой модели (без категориальной привязки)
        Category::where('slug', 'remont-telefonov')->update(['seo_bottom_text' => $phonesText]);
        Category::where('slug', 'remont-planshetov')->update(['seo_bottom_text' => $tabletsText]);

        // Бренды — тексты привязаны к категории remont-telefonov через отдельную таблицу
        $phoneCategoryId = Category::where('slug', 'remont-telefonov')->value('id');

        // 1. УНИВЕРСАЛЬНЫЙ ТЕКСТ ДЛЯ БРЕНДОВ (Таблица: BrandCategorySeoText, Категория: remont-telefonov)
        // Тег <бренд> мы будем заменять динамически в шаблоне.
        $textPhoneBrand = <<<'HTML'
<h2>Ремонт телефонов &lt;бренд&gt;</h2><p>У смартфонов &lt;бренд&gt; привлекательная цена при хорошей начинке: от мощного процессора и качественного экрана до ёмкого аккумулятора. И они отлично ведут себя в эксплуатации, если судить по отзывам владельцев. Но даже самая надёжная техника может ломаться.</p><h3>Почему возникают неисправности</h3><ol><li>Падение — трескается стекло, выходит из строя дисплей, деформируется корпус.</li><li>Попадание жидкости — окисляются контакты, устройство может полностью выйти из строя.</li><li>Дешёвое неоригинальное зарядное устройство — скачки напряжения повреждают контроллер питания и аккумулятор.</li><li>Естественный износ — батарея теряет ёмкость, разъёмы и динамики работают хуже.</li></ol><h3>Нужен срочный ремонт? Обращайтесь!</h3><p>Наши мастера работают с любыми моделями телефонов &lt;бренд&gt;:</p><ul><li>меняют разбитый дисплей и сенсорное стекло;</li><li>ремонтируют аккумулятор и контроллер питания;</li><li>восстанавливают динамики, микрофоны, разъёмы зарядки;</li><li>чинят механические кнопки и элементы корпуса;</li><li>чистят от пыли и влаги, устраняют последствия окисления.</li></ul><p>Все условия ремонта фиксируются в договоре до начала работ и остаются неизменными.</p><h3>С нами выгодно, удобно и надёжно</h3><ul><li><b>Бесплатная диагностика.</b> Определим причину и не возьмём деньги за осмотр.</li><li><b>Оперативный ремонт.</b> Большинство неисправностей устраняем в присутствии заказчика.</li><li><b>Качественные запчасти.</b> Используем надёжные комплектующие от проверенных поставщиков.</li><li><b>Гарантия.</b> Даём двухлетнюю гарантию на работы и установленные детали.</li><li><b>Сохранность данных.</b> Ваши фото, видео, документы остаются конфиденциальными.</li></ul><p>По всем вопросам звоните по номеру +7 (343) 226-46-22 или приезжайте лично. Точную стоимость ремонта назовёт мастер после осмотра.</p>
HTML;

        $brandSeoTexts = [
            'apple' => $textPhoneBrand,
            'samsung' => $textPhoneBrand,
            'xiaomi' => $textPhoneBrand,
            'honor' => $textPhoneBrand,
            'huawei' => $textPhoneBrand,
            'google-pixel' => $textPhoneBrand,
        ];

        foreach ($brandSeoTexts as $brandSlug => $text) {
            $brandId = Brand::where('slug', $brandSlug)->value('id');
            if ($brandId && $phoneCategoryId) {
                BrandCategorySeoText::updateOrCreate(
                    ['brand_id' => $brandId, 'category_id' => $phoneCategoryId],
                    ['seo_bottom_text' => $text]
                );
            }
        }

        $phoneCategory = Category::where('slug', 'remont-telefonov')->first();
        if ($phoneCategory) {
            $phoneServiceSeoTexts = [
                'zamena-stekla' => $textScreenGlass,
                'zamena-ekrana' => $textDisplay,
                'zamena-akkumulyatora' => $textBattery,
                'zamena-kamery' => $textCamera,
                'zamena-stekla-kamery' => $textCameraGlass,
                'zamena-razema-zaryadki' => $textChargingPort,
                'remont-posle-zalitiya' => $textWater,
                'zamena-zadnej-kryshki' => $textBackCover,
                'zamena-mikrofona' => $textMic,
                'zamena-dinamika' => $textSpeaker,
                'proshivka-po' => $textFirmware,
                'razblokirovka' => $textUnlock,
            ];

            foreach ($phoneServiceSeoTexts as $serviceSlug => $seoText) {
                $service = Service::where('slug', $serviceSlug)->first();
                if ($service) {
                    ServiceScope::updateOrCreate(
                        [
                            'scope_type' => 'category',
                            'scope_id'   => $phoneCategory->id,
                            'service_id' => $service->id,
                        ],
                        [
                            'seo_bottom_text' => $seoText,
                        ]
                    );
                }
            }
        }

        // Slug в БД совпадают с defects_data.php (без суффикса -tel); один slug может быть в нескольких категориях — SEO только для «Телефоны».
        $phoneDefectSeo = [
            'razbitoe-steklo' => $textDefectGlass,
            'ne-zaryazhaetsya' => $textDefectNoCharge,
            'bystro-razryazhaetsya' => $textDefectBatteryDrain,
            'popala-voda' => $textDefectWater,
            'net-seti' => $textDefectNoSignal,
            'ne-rabotaet-wi-fi' => $textDefectNoWifi,
            'ne-rabotaet-kamera' => $textDefectNoCamera,
            'ne-rabotaet-zvuk' => $textDefectNoSound,
            'ne-vklyuchaetsya' => $textDefectNoPower,
            'tormozit' => $textDefectSlow,
            'glyuchit-sensor' => $textDefectSensor,
            'ne-rabotaet-knopka-vklyucheniya' => $textDefectPowerButton,
            'ne-vidit-sim-kartu' => $textDefectNoSim,
            'ne-rabotaet-face-id' => $textDefectFaceId,
            'ne-rabotaet-skaner-otpechatka' => $textDefectFingerprint,
        ];
        if ($phoneCategoryId) {
            foreach ($phoneDefectSeo as $defectSlug => $seoText) {
                    Defect::where('category_id', $phoneCategoryId)->where('slug', $defectSlug)->update(['seo_bottom_text' => $seoText]);
                }
            }

            // ──────────────────────────────────────────────────────────────────
            // Per-model SEO-тексты для телефонов (используют тег <модель> в шаблоне)
            // ──────────────────────────────────────────────────────────────────
            $textPhoneModelApple = <<<'HTML'
<h2>Ремонт iPhone &lt;модель&gt;</h2><p>В iPhone &lt;модель&gt; передовые технологии сочетаются с высоким качеством материалов и сборки. Но даже такая техника не застрахована от неисправностей и повреждений. Наш сервисный центр может восстановить модель в кратчайшие сроки. Благодаря огромному опыту мастера профессионально устраняют поломки любой сложности.</p><h3>Виды неисправностей, с которыми мы работаем</h3><p>Владельцы iPhone &lt;модель&gt; сталкиваются с различными проблемами:</p><ul><li>повреждение дисплейного модуля (трещины, отсутствие реакции сенсора, нарушение цветопередачи);</li><li>снижение ёмкости аккумулятора, невозможность зарядить устройство;</li><li>выход из строя динамиков, микрофона, разъёма питания;</li><li>неработающие механические кнопки (включения, регулировки громкости);</li><li>последствия воздействия жидкости (окисление контактов, коррозия элементов платы);</li><li>сбои в работе программного обеспечения.</li></ul><h3>Почему нам доверяют</h3><p>Работаем прозрачно и честно, не навязываем дополнительных услуг. Условия ремонта фиксируются в договоре до начала работ и не меняются.</p><p>Кроме того, всегда:</p><ul><li><b>Бесплатно диагностируем поломку.</b> Специалист определяет причину и предлагает лучший способ восстановления.</li><li><b>Ремонтируем в среднем от 30 минут.</b> В большинстве случаев чиним смартфон в присутствии заказчика.</li><li><b>Используем проверенные комплектующие.</b> Детали поставляются напрямую от надёжных производителей и соответствуют заводским спецификациям.</li><li><b>Предоставляем гарантию до двух лет.</b> Она распространяется на все работы и установленные детали.</li><li><b>Обеспечиваем конфиденциальность.</b> Фото, документы и другая личная информация в телефоне остаются в безопасности.</li></ul><p>Итоговая стоимость ремонта зависит от характера поломки. Точную сумму мастер назовёт после осмотра. Для консультации звоните: +7 (343) 226-46-22.</p>
HTML;

            $textPhoneModelSamsung = <<<'HTML'
<h2>Ремонт Samsung &lt;модель&gt;</h2><p>Смартфоны Samsung &lt;модель&gt; зарекомендовали себя как надёжные устройства с продуманной системой защиты. Но и они ломаются от падений, контакта с водой, скачков напряжения или естественного износа. Если такое произошло, в сервисном центре «Свой Мастер» можно оперативно восстановить модель. Специалисты с огромным опытом эффективно решают задачи любой сложности.</p><h3>Виды работ</h3><p>Чаще всего владельцы Samsung &lt;модель&gt; обращаются по следующим вопросам:</p><ul><li>замена дисплейного модуля при механических повреждениях (трещинах, отсутствии сенсорной реакции, дефектах изображения);</li><li>восстановление работоспособности аккумуляторной батареи и контроллера питания;</li><li>ремонт динамиков, микрофона, разъёма для зарядки;</li><li>восстановление механических кнопок (питания, регулировки громкости);</li><li>устранение последствий контакта с жидкостью (чистка от окислов, замена повреждённых компонентов);</li><li>программное обслуживание, включая перепрошивку и восстановление системных функций.</li></ul><h3>5 причин обратиться в «Свой Мастер»</h3><ol><li><b>Бесплатная диагностика.</b> Не нужно платить за осмотр, специалист определяет источник неполадки и предлагает оптимальный вариант восстановления.</li><li><b>Оперативность.</b> В большинстве случаев работа выполняется в присутствии заказчика, длительное ожидание исключено.</li><li><b>Качество комплектующих.</b> Используются запчасти от проверенных производителей, отвечающие заводским спецификациям.</li><li><b>Гарантия 24 месяца.</b> Сервис несёт официальную ответственность за выполненные работы и установленные компоненты.</li><li><b>Безопасность данных.</b> Личная информация, фото, видео, документы в телефоне полностью конфиденциальны.</li></ol><p>Для консультации наберите номер +7 (343) 226-46-22 или оставьте онлайн-заявку на ремонт.</p>
HTML;

            $textPhoneModelXiaomi = <<<'HTML'
<h2>Ремонт Xiaomi &lt;модель&gt;</h2><p>Смартфоны Xiaomi &lt;модель&gt; сочетают производительное аппаратное обеспечение, качественный дисплей и ёмкий аккумулятор. Но при всех достоинствах от неисправностей они не застрахованы. И главное в подобной ситуации — доверить устройство опытным специалистам. Наш сервисный центр восстанавливает такие модели в кратчайшие сроки и профессионально решает задачи разной сложности.</p><h3>Виды ремонтных работ</h3><ul><li>Замена дисплейного модуля при механических повреждениях (трещинах, нарушении цветопередачи, отсутствии реакции сенсора).</li><li>Восстановление работоспособности аккумулятора и цепи питания.</li><li>Ремонт акустических компонентов (динамиков, микрофона), разъёма зарядки.</li><li>Восстановление функциональности механических кнопок.</li><li>Устранение последствий контакта с жидкостью (чистка платы, замена окисленных элементов).</li><li>Программное обслуживание (обновление прошивки, устранение системных сбоев).</li></ul><h3>Наше кредо — надёжность, эффективность, порядочность</h3><p>Качество ремонта и обслуживания для нас на первом месте, поэтому мы предлагаем:</p><ul><li><b>Бесплатную диагностику.</b> Специалист осмотрит Xiaomi &lt;модель&gt; и выявит причину проблем. И вам не придётся за это платить.</li><li><b>Максимальную оперативность.</b> Длительное ожидание исключено.</li><li><b>Лучшие комплектующие.</b> Используем только проверенные детали, которые соответствуют заводским спецификациям.</li><li><b>Полную конфиденциальность.</b> Доступ посторонних к личной информации, фотографиям, документам исключён.</li></ul><p>Все условия ремонта предварительно фиксируются в договоре и не меняются до завершения работ. На оказанные услуги и установленные компоненты даём гарантию сроком 2 года.</p>
HTML;

            $textPhoneModelHonor = <<<'HTML'
<h2>Ремонт Honor &lt;модель&gt;</h2><p>Смартфоны Honor &lt;модель&gt; имеют сложную техническую начинку. И в случае поломки ремонтировать их должны опытные специалисты, которые знакомы со всеми нюансами. Наш центр работает с 2010 года и устраняет неисправности любой сложности.</p><h3>Самые востребованные услуги</h3><ul><li>Замена дисплея при повреждениях (трещинах, некорректной цветопередаче, отсутствии реакции сенсора и др.).</li><li>Восстановление АКБ и системы питания.</li><li>Ремонт динамиков, микрофона, разъёма зарядки.</li><li>Восстановление функциональности клавиш.</li><li>Устранение последствий от попадания жидкости.</li><li>Ликвидация программных сбоев, обновление прошивки.</li></ul><h3>Ещё несколько причин обратиться в наш сервис</h3><ul><li><b>Бесплатная диагностика.</b> Специалист находит источник проблемы и предлагает лучшее решение.</li><li><b>Скорость ремонта.</b> Среднее время — 30 минут. Во многих случаях работа выполнятся сразу в присутствии заказчика.</li><li><b>Качественные запчасти.</b> Все детали для &lt;модель&gt; соответствуют заводским спецификациям Honor. Поставляются напрямую от проверенных производителей, что гарантирует надёжность и доступную цену.</li><li><b>Гарантия два года.</b> Предоставляется на выполненные работы и установленные компоненты.</li><li><b>Безопасность данных.</b> У посторонних нет доступа к личной информации, фотографиям, документам в телефоне.</li></ul><p>Помните: самостоятельное вмешательство без специальных знаний и оборудования часто усугубляет проблему. Неправильная разборка, повреждение шлейфов, применение некачественных запчастей могут привести к полной утрате работоспособности. И последующее восстановление в таких случаях требует значительно больших вложений. Поэтому лучше сразу доверить сложные задачи профессионалам.</p>
HTML;

            $textPhoneModelHuawei = <<<'HTML'
<h2>Ремонт Huawei &lt;модель&gt;</h2><p>Самые частые причины поломок смартфонов Huawei &lt;модель&gt; — механические воздействия и контакт с жидкостью. Кроме того, со временем детали изнашиваются, и устройство начинает работать хуже. Но смартфон ещё можно спасти, если доверить ремонт специалистам сервисного центра «Свой Мастер».</p><h3>Профессиональный подход</h3><p>У наших сотрудников за плечами более 15 лет опыта, они используют современное диагностическое оборудование и проверенные методики. Поэтому могут эффективно решать задачи любой сложности: от замены дисплейного модуля, восстановления работоспособности АКБ и контроллера питания до чистки платы, замены окисленных элементов, ремонта акустических компонентов и разъёма зарядки, программного обслуживания.</p><h3>И это еще не всё</h3><ul><li><b>Бесплатная диагностика.</b> Найдём причину и предложим подходящий вариант восстановления.</li><li><b>Быстрый ремонт.</b> Большинство неисправностей устраняем в присутствии клиента.</li><li><b>Качественные запчасти.</b> Используем детали, которые соответствуют заводским спецификациям Huawei.</li><li><b>Двухлетняя гарантия.</b> Вы можете быть уверены в работоспособности восстановленного устройства.</li><li><b>Защита данных.</b> Фото, документы, личная информация в телефоне недоступны посторонним.</li></ul><p>Точную цену ремонта назовёт мастер сразу после осмотра. Дополнительных платежей не будет — стоимость фиксируется в договоре и не меняется до конца работы.</p><p>Важно: не рискуйте чинить сами. Самостоятельная разборка Huawei &lt;модель&gt; без опыта и инструментов часто приводит к повреждению шлейфов и материнской платы. А установка дешёвых неоригинальных деталей вызывает сбои в работе. Доверьте ремонт специалистам — это дешевле, чем покупать новый телефон.</p><p>Остались вопросы? Свяжитесь с нами по телефону +7 (343) 226-46-22.</p>
HTML;

            $textPhoneModelGoogle = <<<'HTML'
<h2>Ремонт Google Pixel &lt;модель&gt;</h2><p>Смартфон Google Pixel &lt;модель&gt; ценится за передовую операционную систему, широкий функционал и высокое качество съёмки. Многие владельцы отмечают и его неприхотливость в эксплуатации. Однако даже такая техника требует периодического обслуживания и ремонта. В нашем сервисном центре вы можете быстро восстановить телефон и не тратить деньги на новый. Мы работаем с 2010 года и берёмся даже за сложные случаи.</p><h3>С какими проблемами чаще всего обращаются</h3><ul><li>Уронили телефон — треснул экран, перестал работать сенсор, повредился корпус.</li><li>Попала влага — контакты окислились, перестали работать зарядка и динамик.</li><li>Усилился естественный износ из-за интенсивной эксплуатации — аккумулятор потерял ёмкость, кнопки хуже нажимаются, разъём расшатывается.</li></ul><p>Большинство проблем с &lt;модель&gt; решаемы. Мы выполняем полный спектр операций:</p><ol><li>Меняем разбитый экран. Используем оригинальные дисплейные модули. Яркость и цветопередача сохраняются.</li><li>Ремонтируем систему питания. Восстанавливаем контроллер заряда, заменяем изношенный аккумулятор.</li><li>Чиним динамики и микрофон. Возвращаем нормальный звук при разговоре и воспроизведении.</li><li>Налаживаем работу кнопок, разъёма USB-C, сканера отпечатков.</li><li>Чистим телефон после намокания, убираем окислы с платы.</li><li>Проводим программную диагностику и перепрошивку при сбоях.</li></ol><h3>Почему выбирают нас</h3><p>Диагностика всегда проводится бесплатно. Сначала мы находим причину, потом предлагаем оптимальный сценарий восстановления и согласуем цену. Ремонт чаще всего делаем в день обращения и в присутствии клиента. Используем только качественные запчасти, которые соответствуют заводским спецификациям Google Pixel. Ваши данные (фото, документы, личная информация) не передаются третьим лицам — это строгое правило нашего сервиса. На все работы и установленные компоненты даём гарантию до двух лет. По всем вопросам звоните: +7 (343) 226-46-22.</p>
HTML;

            // Обновляем seo_bottom_text для моделей в категории "Телефоны" по брендам
            $phoneCategoryId = Category::where('slug', 'remont-telefonov')->value('id');
            $appleBrandId = Brand::where('slug', 'apple')->value('id');
            $samsungBrandId = Brand::where('slug', 'samsung')->value('id');
            $xiaomiBrandId = Brand::where('slug', 'xiaomi')->value('id');
            $honorBrandId = Brand::where('slug', 'honor')->value('id');
            $huaweiBrandId = Brand::where('slug', 'huawei')->value('id');
            $googleBrandId = Brand::where('slug', 'google-pixel')->value('id');

            if ($phoneCategoryId && $appleBrandId) {
                DeviceModel::where('brand_id', $appleBrandId)
                    ->where('category_id', $phoneCategoryId)
                    ->update(['seo_bottom_text' => $textPhoneModelApple]);
            }

            if ($phoneCategoryId && $samsungBrandId) {
                DeviceModel::where('brand_id', $samsungBrandId)
                    ->where('category_id', $phoneCategoryId)
                    ->update(['seo_bottom_text' => $textPhoneModelSamsung]);
            }

            if ($phoneCategoryId && $xiaomiBrandId) {
                DeviceModel::where('brand_id', $xiaomiBrandId)
                    ->where('category_id', $phoneCategoryId)
                    ->update(['seo_bottom_text' => $textPhoneModelXiaomi]);
            }

            if ($phoneCategoryId && $honorBrandId) {
                DeviceModel::where('brand_id', $honorBrandId)
                    ->where('category_id', $phoneCategoryId)
                    ->update(['seo_bottom_text' => $textPhoneModelHonor]);
            }

            if ($phoneCategoryId && $huaweiBrandId) {
                DeviceModel::where('brand_id', $huaweiBrandId)
                    ->where('category_id', $phoneCategoryId)
                    ->update(['seo_bottom_text' => $textPhoneModelHuawei]);
            }

            if ($phoneCategoryId && $googleBrandId) {
                DeviceModel::where('brand_id', $googleBrandId)
                    ->where('category_id', $phoneCategoryId)
                    ->update(['seo_bottom_text' => $textPhoneModelGoogle]);
            }

            $this->command->info('  ✓ SEO-тексты добавлены: 2 категории + 4 бренда + модели (категория: Телефоны)');

            // ──────────────────────────────────────────────────────────────────
            // SEO-тексты для планшетов (iPad, Samsung, Xiaomi)
            // ──────────────────────────────────────────────────────────────────
            // 1. ТЕКСТ ДЛЯ БРЕНДА (Таблица: BrandCategorySeoText, Категория: remont-planshetov, Бренд: apple)
            $textIpadBrand = "<h2>Ремонт планшетов iPad (Apple)</h2><p>Планшеты iPad — эталон мобильных устройств для работы, творчества и учебы. Высокое качество сборки обеспечивает им долговечность, но даже такие устройства выходят из строя.</p><p>Сервисный центр «Свой Мастер» выполняет ремонт iPad всех поколений — от классических моделей до актуальных iPad Pro и iPad Air. Работаем с 2010 года, знаем особенности каждого айпада и имеем доступ к оригинальным комплектующим.</p><h3>Типичные неисправности и способы их устранения</h3><p>Лидер среди обращений — разбитый экран. Конструкция iPad такова, что стекло и матрица часто склеены в единый модуль. Замена дисплея требует аккуратности и специального оборудования. Наши мастера используют нагревательные платформы для размягчения клея, демонтируют поврежденный модуль без риска для корпуса и материнской платы. Устанавливается новый дисплей — оригинальный либо качественный аналог с полной цветопередачей и корректной работой сенсора.</p><p>Проблемы с аккумулятором на втором месте. iPad — устройство с большой батареей, но со временем она изнашивается. Признаки: быстрая разрядка, выключение при остатке заряда, вздутие корпуса. Замена аккумулятора — процедура, требующая осторожности. Мастер разбирает планшет, отсоединяет старую батарею, устанавливает новую, соответствующую заводским характеристикам. После замены корпус собирается с восстановлением заводской герметичности.</p><p>iPad не включается, не заряжается — еще одна частая проблема. Причин несколько: выход из строя контроллера питания, поломка разъема Lightning, проблемы с программным обеспечением. Специалист проводит бесплатную диагностику, определяет источник неисправности. В большинстве случаев требуется замена разъема или контроллера питания — операции с пайкой на материнской плате. Программные сбои решаются перепрошивкой через iTunes или использованием специализированного ПО с сохранением данных (при возможности).</p><p>Жидкость внутри — одна из самых сложных поломок. Наши инженеры проводят полную чистку платы ультразвуком, удаляют окислы, заменяют поврежденные компоненты. Успех восстановления зависит от того, как быстро владелец обратился в сервис.</p><h3>Почему мы</h3><ul><li><b>Бесплатная диагностика.</b> Вы узнаете причину до начала ремонта.</li><li><b>Прозрачные условия.</b> Договор фиксирует стоимость, никаких доплат.</li><li><b>Качественные комплектующие.</b> Используем детали, соответствующие оригинальным характеристикам. Прямые поставки исключают подделки.</li><li><b>Гарантия до двух лет.</b> На все виды работ и установленные компоненты.</li><li><b>Сохранность данных.</b> Личная информация конфиденциальна.</li></ul><p>Для записи на ремонт iPad звоните по контактному номеру.</p>";

            // 2. ТЕКСТ ДЛЯ МОДЕЛЕЙ (Будет выводиться на странице конкретного iPad)
            // Тег <модель> мы будем заменять динамически в шаблоне.
            $textIpadModel = "<h2>Ремонт планшетов iPad <модель></h2><p>iPad <модель> — устройство, сочетающее производительность и компактность. Но даже самая продуманная техника требует ремонта. Сервисный центр «Свой Мастер» выполняет восстановление данной модели с гарантией до двух лет.</p><h3>С чем обращаются владельцы</h3><p>Чаще всего — с разбитым экраном. В iPad <модель> стекло и матрица объединены в единый модуль, поэтому замена производится в сборе. Мастер аккуратно вскрывает устройство с помощью нагревательной платформы, демонтирует поврежденный дисплей, устанавливает новый модуль. После сборки проверяются работа сенсора, яркость, цветопередача.</p><p>Вторая по частоте проблема — аккумулятор. Со временем батарея теряет емкость. Признаки: планшет быстро разряжается, выключается при 20–30 % заряда. Замена выполняется с соблюдением технологии производителя. Старая батарея отсоединяется от контроллера питания, устанавливается новая, корпус собирается с восстановлением заводской герметичности.</p><p>Также владельцы обращаются по поводу неработающего разъема зарядки, проблем с кнопками, отсутствия звука, последствий залития. Программные сбои решаются перепрошивкой с сохранением данных при возможности.</p><h3>Как мы работаем</h3><p>Процесс начинается с бесплатной диагностики. Сам ремонт выполняется в присутствии клиента либо в минимальные сроки. После завершения планшет проходит тестирование всех функций.</p><h3>Почему выбирают «Свой Мастер»:</h3><ul><li><b>Качественные комплектующие.</b> Используем модули, соответствующие оригинальным характеристикам.</li><li><b>Прозрачная цена.</b> Стоимость фиксируется в договоре до начала работ.</li><li><b>Сохранность данных.</b> Личная информация не передается третьим лицам.</li></ul><p>Для записи на ремонт iPad <модель> звоните по контактному номеру.</p>";

            // Additional tablet brand texts: Samsung и Xiaomi
            $textSamsungTabletBrand = "<h2>Ремонт планшетов Samsung</h2><p>Планшеты Samsung занимают лидирующие позиции на рынке благодаря ярким AMOLED-экранам, мощным процессорам и функциональной оболочке One UI. Но и такая надежная техника требует профессионального обслуживания.</p><p>Сервисный центр «Свой Мастер» выполняет ремонт планшетов Samsung всех серий — от бюджетных Galaxy Tab A до флагманских Tab S. Опыт работы с 2010 года позволяет нашим инженерам справляться с неисправностями любой сложности.</p><h3>Как проходит ремонт</h3><p>Все начинается с бесплатной диагностики. Специалист подключает планшет к оборудованию, выявляет причину, озвучивает стоимость. После завершения ремонта он проходит тестирование: сенсор, динамики, камера, кнопки, Wi-Fi, зарядка.</p><h4>Преимущества обращения в «Свой Мастер»:</h4><ul><li><b>Прозрачные условия.</b> Договор фиксирует все детали.</li><li><b>Качественные комплектующие.</b> Используем детали, соответствующие заводским спецификациям. Прямые поставки исключают подделки.</li><li><b>Гарантия до двух лет.</b> На работы и установленные компоненты.</li><li><b>Сохранность данных.</b> Личная информация конфиденциальна.</li></ul><h3>Наиболее частые неисправности</h3><p><b>Повреждение экрана.</b> У планшетов Samsung дисплей часто состоит из двух компонентов: стекла и матрицы. Если изображение остается четким, сенсор работает корректно — возможна замена только стекла. Это дешевле и сохраняет оригинальную матрицу. Если же появились пятна, полосы, сенсор не реагирует — требуется замена дисплея в сборе. Наши мастера используют вакуумные столы и нагревательные платформы для безопасного отделения стекла или демонтажа модуля.</p><p><b>Проблемы с аккумулятором.</b> При активной эксплуатации батарея изнашивается за 2–3 года. Признаки: быстрая разрядка, выключение при остатке заряда. Мастер отсоединяет старую АКБ, устанавливает новую, соответствующую заводской емкости, и восстанавливает герметичность корпуса.</p><p><b>Неисправности разъема зарядки (USB-C).</b> Частая проблема при использовании неоригинальных кабелей. Контакты расшатываются, планшет заряжается только в определенном положении или не заряжается вовсе. Наши специалисты выполняют замену с пайкой, соблюдая температурный режим.</p><p><b>Последствия залития.</b> Влага вызывает коррозию контактов и короткое замыкание. Мастера проводят полную чистку платы ультразвуком, удаляют окислы, заменяют поврежденные элементы.</p><p><b>Программные сбои.</b> Зависания, ошибки приложений, проблемы с обновлениями решаются перепрошивкой. Данные сохраняются при возможности.</p><p>Для записи на ремонт звоните по контактному номеру.</p>";

            $textXiaomiTabletBrand = "<h2>Ремонт планшетов Xiaomi</h2><p>Планшеты Xiaomi популярны для просмотра видео, учебы и игр. В ЕКБ ремонтом данных гаджетов занимается сервисный центр «Свой Мастер». Опыт работы с 2010 года позволяет нашим инженерам успешно справляться с любыми проблемами.</p><h3>Типичные неисправности</h3><p><b>Повреждение экрана.</b> У планшетов Xiaomi дисплей часто представляет собой модуль, где стекло и матрица склеены. Мастер аккуратно вскрывает устройство с помощью нагревательной платформы, демонтирует поврежденный элемент, устанавливает новый. После сборки проверяются работа сенсора, яркость, цветопередача. Если треснуло только стекло, а изображение остается четким — возможна замена только стекла.</p><p><b>Проблемы с аккумулятором.</b> Признаки износа: быстрая разрядка, выключение при остатке заряда, вздутие корпуса. Замена аккумулятора требует аккуратного вскрытия, так как батарея часто зафиксирована клеевым составом. Мастер отсоединяет старую батарею, устанавливает новую, соответствующую заводской емкости. После замены корпус собирается с восстановлением герметичности.</p><p><b>Неисправности разъема зарядки (USB-C).</b> Частая проблема при использовании неоригинальных кабелей. Контакты расшатываются, планшет заряжается только в определенном положении или не реагирует на подключение. Разъем во многих моделях впаян в материнскую плату, требуется профессиональная пайка. Наши специалисты выполняют замену с соблюдением температурного режима.</p><p><b>Последствия залития.</b> Жидкость вызывает коррозию контактов и короткое замыкание. Мастера проводят полную чистку платы ультразвуком, удаляют окислы, заменяют поврежденные элементы.</p><p><b>Программные сбои.</b> Зависания, ошибки приложений, проблемы с обновлениями решаются перепрошивкой через официальное ПО. Данные сохраняются при возможности.</p><h3>Как происходит ремонт</h3><p>Первый этап — бесплатная диагностика. Специалист подключает планшет к оборудованию, проверяет состояние дисплея, аккумулятора, контроллера питания.</p><p>После выявления причины поломки озвучиваются стоимость и сроки. Условия фиксируются в договоре.</p><p>Для ремонта используются детали, соответствующие заводским спецификациям. Клиент может наблюдать за работой.</p><p>После завершения устройство проходит тестирование: сенсор, динамики, камера, кнопки, Wi-Fi, зарядка. Гарантия — до двух лет.</p><p>Для записи на ремонт планшета Xiaomi звоните по контактному номеру.</p>";

            // Текст для моделей Samsung (заменяем тег &lt;модель&gt; в шаблоне)
            $textSamsungTabletModel = "<h2>Ремонт планшетов Samsung &lt;модель&gt;</h2><p>Планшет Samsung &lt;модель&gt; — высокотехнологичное устройство, требующее профессионального подхода при ремонте. В Екатеринбурге восстановление этой модели выполняет сервисный центр «Свой Мастер». Работаем с 2010 года, предоставляем гарантию на 24 месяца.</p><h3>Частые причины обращений к нам</h3><p><b>Разбитый экран.</b> В зависимости от характера повреждений возможна замена только стекла или полная замена дисплейного модуля. Если изображение четкое, сенсор работает — меняем стекло. Если есть пятна, полосы, сенсор не реагирует — требуется модуль в сборе. Мастер проводит диагностику, предлагает оптимальный вариант. Ремонт выполняется с использованием нагревательных платформ и вакуумного стола.</p><p><b>Проблемы с аккумулятором.</b> Со временем батарея теряет емкость. Признаки: быстрая разрядка, выключение при 20–30 % заряда, вздутие корпуса. Замена выполняется аккуратно: старый аккумулятор отсоединяется от контроллера питания, устанавливается новый, соответствующий заводским характеристикам.</p><p><b>Не работает разъем зарядки.</b> Типично при использовании неоригинальных кабелей. Разъем USB-C расшатывается, планшет заряжается только в определенном положении. Наши специалисты выполняют замену с пайкой, соблюдая температурный режим.</p><h3>Как мы работаем</h3><p>Процесс начинается с бесплатной диагностики. Специалист определяет причину неисправности, согласовывает стоимость. Условия фиксируются в договоре. Ремонт выполняется в присутствии клиента. Используем только детали, соответствующие оригинальным характеристикам. После завершения планшет проходит тестирование всех функций.</p><p>Для записи на ремонт Samsung &lt;модель&gt; звоните по контактному номеру.</p>";

            // Обновляем записи в базе
            $tabletCategoryId = Category::where('slug', 'remont-planshetov')->value('id');
            $appleBrandId = Brand::where('slug', 'apple')->value('id');
            $samsungBrandId = Brand::where('slug', 'samsung')->value('id');
            $xiaomiBrandId = Brand::where('slug', 'xiaomi')->value('id');

            if ($tabletCategoryId && $appleBrandId) {
                BrandCategorySeoText::updateOrCreate(
                    ['brand_id' => $appleBrandId, 'category_id' => $tabletCategoryId],
                    ['seo_bottom_text' => $textIpadBrand]
                );

                DeviceModel::where('brand_id', $appleBrandId)
                    ->where('category_id', $tabletCategoryId)
                    ->update(['seo_bottom_text' => $textIpadModel]);
            }

            if ($tabletCategoryId && $samsungBrandId) {
                BrandCategorySeoText::updateOrCreate(
                    ['brand_id' => $samsungBrandId, 'category_id' => $tabletCategoryId],
                    ['seo_bottom_text' => $textSamsungTabletBrand]
                );

                DeviceModel::where('brand_id', $samsungBrandId)
                    ->where('category_id', $tabletCategoryId)
                    ->update(['seo_bottom_text' => $textSamsungTabletModel]);
            }

            if ($tabletCategoryId && $xiaomiBrandId) {
                BrandCategorySeoText::updateOrCreate(
                    ['brand_id' => $xiaomiBrandId, 'category_id' => $tabletCategoryId],
                    ['seo_bottom_text' => $textXiaomiTabletBrand]
                );
            }

            // 1. УНИВЕРСАЛЬНЫЙ ТЕКСТ ДЛЯ БРЕНДОВ ПЛАНШЕТОВ (Таблица: BrandCategorySeoText, Категория: remont-planshetov)
            // Тег <бренд> мы будем заменять динамически в шаблоне.
            $textTabletBrand = "<h2>Ремонт планшетов &lt;бренд&gt;</h2><p>Планшеты &lt;бренд&gt; пользуются спросом благодаря функциональности и надежности. Но если возникает необходимость, найти сервис, который возьмется за ремонт, бывает непросто — многие работают с ограниченным кругом моделей.</p><p>В Екатеринбурге восстановлением планшетов &lt;бренд&gt; занимается центр «Свой Мастер». Опыт с 2010 года позволяет нашим инженерам решать проблемы любой сложности.</p><h3>Типичные неисправности</h3><p>Чаще всего владельцы обращаются по поводу разбитого экрана. Планшеты, как правило, используются активно — падения неизбежны. Вторая по частоте причина — проблемы с аккумулятором. Со временем батарея теряет емкость, устройство выключается при остатке заряда. Также нередки поломки разъема зарядки, неработающие кнопки, сбои динамиков и микрофонов, последствия залития.</p><h3>Как проходит ремонт</h3><p>Процесс начинается с диагностики. Мастер определяет причину, оценивает сложность и называет стоимость. Все условия фиксируются в договоре.</p><p>После согласования специалист приступает к работе. В зависимости от неисправности выполняется замена экрана, аккумулятора, разъема или других компонентов. Применяются качественные комплектующие, соответствующие заводским спецификациям. Прямые поставки исключают подделки и посреднические наценки.</p><p>После ремонта устройство проходит тестирование: проверяется зарядка, работа сенсора, динамиков, камер, кнопок. Клиент может наблюдать за процессом в сервисе. Гарантия на работы и детали — до двух лет.</p><h3>Почему выбирают «Свой Мастер»:</h3><ul><li><b>Бесплатная диагностика</b> без предоплаты.</li><li><b>Ремонт в присутствии клиента.</b></li><li><b>Сохранность данных</b> — личная информация не передается третьим лицам.</li></ul><p>Для записи позвоните нам — ответим на все интересующие вопросы.</p>";

            // 2. УНИКАЛЬНЫЙ ТЕКСТ ДЛЯ ПЛАНШЕТОВ HUAWEI
            $textTabletHuawei = "<h2>Ремонт планшетов Huawei</h2><p>Планшеты Huawei занимают прочную позицию на рынке благодаря собственным процессорам Kirin, качественным экранам и фирменной оболочке HarmonyOS или EMUI. Однако техническая сложность этих устройств требует от мастера глубоких знаний архитектуры и доступа к специализированному ПО.</p><p>Сервисный центр «Свой Мастер» в Екатеринбурге выполняет ремонт планшетов Huawei любых моделей — от бюджетных MediaPad до премиальных MatePad Pro.</p><h3>Почему выходят из строя планшеты Huawei</h3><p>Основная причина — механические повреждения. Падения и удары приводят к трещинам на стекле, деформации корпуса, выходу сенсора из строя.</p><p>Вторая распространенная проблема — попадание жидкости. Даже модели без официальной влагозащиты нередко используются на кухне или в ванной, что заканчивается коррозией контактов.</p><p>Применение неоригинальных зарядных устройств выводит из строя контроллер питания — планшет заряжается медленно или не реагирует на подключение кабеля.</p><h3>Спектр услуг</h3><p>Перечень выполняемых работ включает:</p><ul><li>замену дисплейного модуля;</li><li>восстановление работоспособности аккумулятора и контроллера питания, ремонт разъема зарядки (USB-C), динамиков, микрофонов;</li><li>устранение последствий залития с чисткой платы ультразвуком;</li><li>программное обслуживание (перепрошивка, восстановление после неудачных обновлений).</li></ul><p>Конструкция планшетов Huawei часто предполагает неразборные корпуса с плотной посадкой компонентов. Это усложняет замену дисплея, аккумулятора или задней крышки. Наши специалисты владеют технологией безопасного вскрытия таких устройств с сохранением заводской герметичности.</p><p>Особое внимание уделяется сохранению защиты от влаги — после ремонта корпус собирается с применением фирменных клеевых составов.</p><h3>Причины обратиться к нам</h3><p>Сервисный центр «Свой Мастер» работает по принципу полной прозрачности. Инженеры «не придумывают» несуществующих неисправностей.</p><p>Диагностика проводится бесплатно, стоимость ремонта озвучивается до начала работ и фиксируется в договоре. Клиент может наблюдать за процессом в сервисе или забрать устройство в оговоренный срок.</p><p>На все виды ремонта (от замены стекла до сложного восстановления после залития) предоставляется гарантия до 2 лет.</p>";

            // 3. УНИКАЛЬНЫЙ ТЕКСТ ДЛЯ ПЛАНШЕТОВ HONOR
            $textTabletHonor = "<h2>Ремонт планшетов Honor</h2><p>Планшеты Honor выделяются сбалансированными характеристиками, качественными экранами и доступной ценой. Они популярны для учебы, работы и развлечений. Но даже надежная техника порой выходит из строя.</p><p>Сервисный центр «Свой Мастер» в Екатеринбурге выполняет ремонт планшетов Honor всех поколений — от первых моделей до актуальных серий Pad. Многолетний опыт позволяет нам быстро и качественно устранять любые неисправности.</p><h3>С чем сталкиваются владельцы</h3><p>Чаще всего обращаются с разбитыми экранами. Планшет — устройство переносное, падения бывают неизбежны. Если матрица повреждена, появляются пятна, полосы, сенсор перестает реагировать. В таких случаях требуется замена дисплея в сборе. Если изображение остается четким, возможна замена только защитного стекла — это дешевле и сохраняет оригинальную матрицу.</p><p>Вторая распространенная категория — проблемы с аккумулятором. Со временем батарея изнашивается: планшет быстро разряжается, выключается при 20–30 %, перестает заряжаться. Замена аккумулятора требует аккуратного вскрытия корпуса, так как во многих моделях используется плотный клеевой состав.</p><p>Также владельцы сталкиваются с выходом из строя разъема зарядки, поломкой кнопок питания и громкости, проблемами с динамиками и микрофоном, последствиями залития.</p><h3>Как мы ремонтируем</h3><p>Специалист подключает планшет к тестеру, проверяет состояние батареи, дисплея, контроллера питания. Определяется точная причина и озвучивается стоимость.</p><p>Мастер выполняет работы с соблюдением технологии производителя:</p><ul><li>при замене экрана используется демонтаж без повреждения материнской платы и камеры;</li><li>при замене аккумулятора применяется аккуратное нагревание для размягчения клея;</li><li>программные проблемы решаются перепрошивкой с сохранением данных (при возможности).</li></ul><p>После ремонта устройство проходит полное тестирование: зарядка, сенсор, динамики, камера, кнопки, Wi-Fi.</p><h3>Почему выбирают «Свой Мастер»:</h3><ul><li><b>Наличие запчастей.</b> Комплектующие для планшетов Honor закупаются напрямую, гарантированы совместимость и качество. Нет необходимости ждать неделями.</li><li><b>Прозрачная цена.</b> Диагностика бесплатна, договор подписывается до начала ремонта. Стоимость формируется из цены запчасти и работы мастера. Дополнительных наценок нет.</li><li><b>Сохранность данных.</b> Личная информация не передается третьим лицам.</li><li><b>Ремонт в присутствии.</b> Клиент может наблюдать за процессом.</li></ul><p>Гарантия до двух лет распространяется на все виды работ и установленные детали.</p>";

            // 4. ТЕКСТ ДЛЯ КАТЕГОРИИ "РЕМОНТ НОУТБУКОВ" (Выводится на странице самой категории)
            $textLaptopsCategory = "<h2>Ремонт ноутбуков</h2><p>Сломанный ноутбук способен сильно усложнить работу и учебу. В сервисном центре «Свой Мастер» в Екатеринбурге вы можете доверить восстановление техники профессионалам. Мы ремонтируем ноутбуки всех марок с 2010 года. Все работы и детали защищены гарантией сроком до двух лет.</p><h3>Основные неисправности и методы их устранения</h3><ul><li><b>Не включается.</b> Причин несколько: разряженный аккумулятор, неисправный блок питания, выход из строя контроллера питания, короткое замыкание на материнской плате. В зависимости от причины выполняется замена блока питания, материнской платы, ремонт схемы и пр.</li><li><b>Проблемы с экраном (нет изображения, полосы, мерцание, трещины).</b> Механические повреждения требуют замены матрицы. Если изображение отсутствует, но есть подсветка, — возможно, поврежден шлейф экрана или вышел из строя графический чип. Специалист проверяет шлейф, при необходимости пересаживает его или заменяет. При выходе из строя дискретной видеокарты ремонт сложнее — требуется перепайка чипа или замена материнской платы.</li><li><b>Перегрев, шум кулера, внезапное выключение.</b> Самая частая причина: забитая пылью система охлаждения. Мастер полностью разбирает ноутбук, чистит радиатор и вентилятор, заменяет термопасту на процессоре и видеокарте. Если кулер издает скрежет — требуется замена подшипника или всего вентилятора.</li><li><b>Не работает клавиатура или тачпад.</b> Отдельные клавиши можно заменить (в некоторых моделях). Но чаще требуется замена всей клавиатуры. Для этого необходимо полностью разобрать ноутбук — тачпад меняется модулем целиком.</li><li><b>Проблемы с зарядкой (не заряжается, разъем болтается).</b> Частая причина — износ гнезда питания. В современных ноутбуках такой элемент часто впаян в материнскую плату. Также может выйти из строя контроллер заряда — его диагностируют и заменяют.</li><li><b>Зависания, ошибки, вирусы.</b> Программные проблемы решаются переустановкой операционной системы, заменой жесткого диска на твердотельный накопитель (SSD), который существенно ускоряет работу, установкой драйверов.</li></ul><h3>Как проходит ремонт</h3><p>Все начинается с диагностики. Клиент приносит ноутбук, специалист подключает оборудование, выявляет причину неисправности и озвучивает стоимость. Если требуется замена деталей, подбираются совместимые компоненты — оригинальные или качественные аналоги.</li></ul><h3>Преимущества обращения в «Свой Мастер»:</h3><ul><li><b>Бесплатная диагностика.</b> Вы узнаете причину и стоимость до начала ремонта.</li><li><b>Прозрачные условия.</b> Договор фиксирует все детали, никаких доплат.</li><li><b>Качественные комплектующие.</b> Используем детали от проверенных поставщиков. Прямые поставки исключают подделки.</li><li><b>Сохранность данных.</b> Личная информация конфиденциальна, при переустановке ПО данные сохраняются (при возможности).</li></ul><h3>Почему важно обращаться к профессионалам</h3><p>Ремонт ноутбука без специальных знаний часто приводит к ухудшению ситуации. Неправильная разборка повреждает шлейфы и корпус. Самостоятельная замена термопасты может вывести процессор из строя из-за неправильной дозировки. Попытки перепаять разъем без навыков уничтожают материнскую плату. Доверьте ноутбук специалистам «Свой Мастер»!</p><p>Для записи на ремонт позвоните нам. Проконсультируем по стоимости и срокам.</p>";

            // ==========================================
            // 1. ТЕКСТЫ ДЛЯ НОУТБУКОВ (MacBook)
            // ==========================================

            // Бренд MacBook (Таблица: BrandCategorySeoText, Категория: remont-noutbukov, Бренд: apple)
            $textMacbookBrand = "<h2>Ремонт ноутбуков Apple MacBook</h2><p>Ноутбуки Apple MacBook отличаются высоким качеством сборки, производительными компонентами, продуманной системой охлаждения. Но даже у них есть слабые места. В сервисном центре «Свой Мастер» в Екатеринбурге эти проблемы знают и умеют с ними работать.</p><h3>Типичные поломки и методы их устранения</h3><ul><li><b>Не включается, не заряжается.</b> Частая причина — выход из строя контроллера питания (T2 или M-серия). Мастер подключает MacBook к лабораторному блоку питания, проверяет цепи. В большинстве случаев требуется перепайка микросхемы или замена материнской платы.</li><li><b>Разбит экран.</b> Дисплейный модуль заменяется целиком — стекло и матрица не разделяются. Специалист подбирает оригинальный модуль по модели, аккуратно демонтирует поврежденный, устанавливает новый. После замены проверяется True Tone, камера, подсветка.</li><li><b>Проблемы с клавиатурой.</b> Западание клавиш, двойное нажатие, отсутствие реакции. Механизм чистится или заменяется. В некоторых случаях нужно полное обновление клавиатуры — операция, требующая выпайки десятков мелких компонентов.</li><li><b>Перегрев, шум кулера.</b> MacBook греется из-за тонкого корпуса. Пыль забивает радиатор за 6–12 месяцев. Мастер разбирает ноутбук, чистит систему охлаждения, заменяет термопасту. Кулер при скрежете меняется.</li></ul><h3>Как организована работа</h3><p>Клиент приходит в сервис. Специалист проводит бесплатную диагностику (15–30 минут). Называется причина и стоимость. Подписывается договор. Ремонт часто выполняется в присутствии заказчика — от 1 до 3 часов. Ноутбук тестируется. Выдается гарантия до двух лет.</p><h3>Почему не стоит решать проблемы самостоятельно?</h3><p>MacBook ремонтировать сложнее, чем обычный ноутбук. Многие компоненты впаяны в материнскую плату. Корпус часто неразборный, с плотным клеевым составом. Запчасти бывает непросто найти. Попытки заменить разъем или аккумулятор без опыта часто заканчиваются повреждением материнской платы. Цена ошибки — потеря всего устройства.</p><p>Доверяйте технику профессионалам! Чтобы записаться или получить консультацию, обращайтесь по телефону.</p>";

            // Модели MacBook (Поле seo_bottom_text у моделей Apple в категории remont-noutbukov)
            $textMacbookModel = "<h2>Ремонт ноутбуков Apple MacBook &lt;модель&gt;</h2><p>MacBook &lt;модель&gt; имеет заслуженную репутацию надежного и производительного ноутбука. Но даже такое качественное устройство подвержено поломкам, неизбежным при интенсивной эксплуатации. В Екатеринбурге профессиональным ремонтом такой модели занимается сервисный центр «Свой Мастер». Предоставляем гарантию до 2 лет.</p><h3>Уязвимые места Apple MacBook &lt;модель&gt;</h3><ul><li><b>Зарядка.</b> Контроллер питания выходит из строя чаще, чем на других моделях. Признаки: ноутбук не видит зарядное устройство, заряжается очень медленно, индикатор не горит. Мастер проверяет цепи питания, при необходимости перепаивает микросхему.</li><li><b>Клавиатура.</b> Клавиши западают или нажимаются дважды. Чистка помогает не всегда. Замена клавиатуры — трудоемкая операция, занимает 2–3 часа.</li><li><b>Экран.</b> Замена дисплея — только в сборе. Стекло отдельно не меняется. Мастер подбирает оригинальный модуль. После установки проверяет работу камеры, датчика освещенности, True Tone.</li><li><b>Аккумулятор.</b> Со временем батарея вздувается, деформируя корпус и тачпад. Замена выполняется с соблюдением техники безопасности. Старый аккумулятор утилизируется.</li></ul><h3>Как проходит ремонт</h3><p>Специалист определяет причину, согласовывает стоимость. Ремонт проводится в присутствии клиента (как правило, занимает не более 1–3 часа). По завершении выполняется тестирование устройства.</p><p>Преимущества обращения в наш сервисный центр:</p><ul><li>Бесплатная диагностика.</li><li>Прозрачная цена (прописывается в договоре).</li><li>Оригинальные комплектующие (от официальных дистрибьюторов).</li><li>Конфиденциальность данных.</li></ul><p>Чтобы получить больше информации, обращайтесь к нам по телефону.</p>";

            // ==========================================
            // 2. ТЕКСТЫ ДЛЯ СМАРТ-ЧАСОВ (Apple Watch и Общий)
            // ==========================================

            // Общий текст для категории "Ремонт смарт-часов" (remont-smart-chasov)
            $textSmartWatchCategory = "<h2>Ремонт смарт-часов</h2><p>Ремонт смарт-часов нередко оказывается сложнее, чем восстановление телефона: корпус герметичен, стекло приклеено по периметру, а многие компоненты впаяны в плату.</p><p>Сервисный центр «Свой Мастер» в Екатеринбурге ремонтирует смарт-часы любых брендов: Samsung, Garmin, Amazfit, Huawei, Xiaomi и др. Наши мастера работают с 2010 года и знают особенности каждой марки. На все виды работ выдается гарантия до 2 лет.</p><h3>С какими неисправностями приходят чаще всего</h3><ul><li><b>Разбит экран.</b> У смарт-часов дисплей очень уязвим. Падение на асфальт — и тут же трещины. У разных моделей конструкция отличается: у одних стекло и матрица объединены, у других — раздельные. Мастер определяет возможность замены только стекла или всего модуля. Восстанавливается герметичность корпуса.</li><li><b>Проблемы с зарядкой.</b> Часы не реагируют на магнитную док-станцию, контакты окислились, разъем (если есть) расшатался. Специалист чистит контакты, при необходимости заменяет зарядный контроллер.</li><li><b>Быстро разряжаются.</b> Аккумулятор износился. Признаки: часов не хватает на день, выключаются при 20–30 % заряда, вздутие корпуса. Замена батареи — одна из самых частых операций.</li><li><b>Не работает пульсометр, GPS, шагомер.</b> Датчики выходят из строя после удара или залития. Мастер диагностирует каждый модуль, заменяет поврежденный.</li><li><b>Программные сбои.</b> Часы зависают, не синхронизируются с телефоном, не обновляются. Перепрошивка через фирменное ПО решает проблему. Данные сохраняются при возможности.</li><li><b>Последствия залития.</b> Даже влагозащищенные модели не вечны. Уплотнители стареют. Вода вызывает коррозию. Мастер разбирает часы, чистит плату ультразвуком, заменяет окисленные компоненты.</li></ul><h3>Как проходит ремонт в центре «Свой Мастер»</h3><ol><li><b>Бесплатная диагностика.</b> Специалист проверяет все функции, определяет причину поломки. Клиент узнает точный диагноз и стоимость.</li><li><b>Согласование.</b> Если клиент согласен, подписывается договор. Цена фиксируется. Никаких доплат.</li><li><b>Ремонт.</b> Используем только сертифицированные комплектующие. Мастер выполняет работы в присутствии заказчика. Время — от 1 до 3 часов.</li><li><b>Проверка.</b> Часы тестируются на герметичность, работу датчиков, зарядку.</li></ol><p>Доверяйте сложные задачи профессионалам! Чтобы записаться на ремонт или получить консультацию, звоните нам.</p>";

            // Бренд Apple Watch (Таблица: BrandCategorySeoText, Категория: remont-smart-chasov, Бренд: apple)
            $textAppleWatchBrand = "<h2>Ремонт смарт-часов Apple Watch</h2><p>Смарт-часы Apple Watch — это миниатюрный компьютер на запястье. В компактном корпусе упакованы материнская плата, аккумулятор, Taptic Engine, несколько антенн, дисплей, кнопки, пульсометр. Ремонт такого устройства требует высокоточных инструментов и квалификации.</p><p>Сервисный центр «Свой Мастер» в Екатеринбурге работает с 2010 года. Огромный опыт вкупе с прямыми поставками комплектующих позволяет нам решать задачи любой сложности качественно и в короткий срок.</p><h3>Какие поломки встречаются у Apple Watch</h3><ul><li><b>Разбит экран.</b> Самая частая причина обращения. Часы ударяются о косяки, падают на плитку. Замена дисплея сложнее, чем на телефоне: корпус герметичен, стекло проклеено по периметру. Мастер нагревает устройство, аккуратно отделяет поврежденный модуль, устанавливает новый. Восстанавливается влагозащита. После замены проверяется работа сенсора и Force Touch (если предусмотрено).</li><li><b>Аккумулятор перестал держать заряд.</b> Часы живут меньше дня, выключаются при 30 % заряда, корпус вздувается. Замена батареи требует разборки, отсоединения дисплея и аккумулятора от платы. Устанавливается новая батарея, соответствующая заводской емкости.</li><li><b>Не работает Digital Crown.</b> Колесико прокрутки перестало вращаться или нажиматься. Причина — загрязнение или механический износ. Мастер разбирает часы, чистит механизм. В сложных случаях проводится замена компонента.</li><li><b>Не включаются, не заряжаются.</b> Проблема в контроллере питания или разъеме магнитной зарядки. Специалист проверяет цепи питания, при необходимости перепаивает микросхемы.</li><li><b>Последствия залития.</b> Apple Watch имеют влагозащиту, но со временем уплотнители изнашиваются. Вода вызывает коррозию. Мастер проводит чистку платы ультразвуком, заменяет окисленные элементы.</li></ul><h3>Как организована работа в центре «Свой Мастер»</h3><ol><li><b>Бесплатная диагностика.</b> Специалист подключает часы к тестеру, проверяет дисплей, аккумулятор, контроллер питания. Определяет причину.</li><li><b>Согласование стоимости.</b> Мастер называет цену. Клиент принимает решение. Если согласен — подписывается договор, где зафиксированы все условия.</li><li><b>Ремонт.</b> Выполняется в присутствии клиента. Время — от 1 до 3 часов.</li><li><b>Тестирование.</b> Проверяется сенсор, кнопки, пульсометр, зарядка, герметичность.</li><li><b>Гарантия.</b> Выдается до двух лет на работы и установленные детали.</li></ol><h3>Почему не стоит ремонтировать Apple Watch самостоятельно?</h3><p>Устройство сложное и герметичное. Попытка вскрыть часы обычными инструментами почти гарантированно повреждает дисплей и корпус. Некорректная замена аккумулятора часто обрывает шлейфы.</p><p>Доверьте ремонт профессионалам! Позвоните, чтобы получить консультацию.</p>";

            // Модели Apple Watch (Поле seo_bottom_text у моделей Apple в категории remont-smart-chasov)
            $textAppleWatchModel = "<h2>Ремонт смарт-часов Apple Watch &lt;модель&gt;</h2><p>Смарт-часы Apple Watch &lt;модель&gt; — компактное устройство с высокой плотностью компонентов. Поэтому ремонт требует микроскопа, специального инструмента и опыта пайки мелких элементов. В Екатеринбурге восстановлением этой модели занимается сервисный центр «Свой Мастер».</p><h3>С чем обращаются владельцы</h3><p><b>Разбитый экран.</b> Это самая частая поломка. Часы носят на руке, поэтому возможны удары о косяки, падение на плитку. Замена дисплея на Apple Watch &lt;модель&gt; сложнее, чем на телефоне: корпус герметичен, стекло плотно приклеено по периметру. Мастер аккуратно нагревает устройство для размягчения клея, демонтирует поврежденный модуль, устанавливает новый.</p><p><b>Проблемы с аккумулятором.</b> Часы перестали держать заряд, выключаются при 20–30 %, вздутие батареи деформирует корпус. Замена выполняется с соблюдением технологии: старая АКБ отсоединяется от контроллера питания, устанавливается новая, соответствующая заводской емкости. Корпус собирается с восстановлением влагозащиты.</p><p><b>Не работает кнопка Digital Crown или боковая клавиша.</b> Механизм загрязняется или выходит из строя. Мастер разбирает часы, чистит контакты либо заменяет компонент.</p><p><b>Последствия залития.</b> Apple Watch имеют влагозащиту, но со временем уплотнители изнашиваются. Вода вызывает коррозию. Специалист проводит чистку платы, замену окисленных элементов.</p><h3>Как проходит ремонт</h3><p>Мастер проверяет состояние дисплея, аккумулятора, контроллера питания. Затем согласовывается стоимость работ и запчастей. Ремонт выполняется в присутствии клиента. После завершения часы проходят тестирование: сенсор, кнопки, пульсометр, зарядка.</p><h3>Почему выбирают «Свой Мастер»:</h3><ul><li><b>Бесплатная диагностика.</b> Никаких предоплат.</li><li><b>Прозрачная цена.</b> Фиксация в договоре.</li><li><b>Гарантия до двух лет.</b> На работы и детали.</li></ul><p>Для записи звоните: +7 (343) 226-46-22.</p>";

            // ==========================================
            // 3. ТЕКСТЫ ДЛЯ КАТЕГОРИЙ "ДРУГИЕ УСТРОЙСТВА"
            // ==========================================

            $textJoysticks = "<h2>Ремонт джойстиков и геймпадов</h2><p>Ремонт джойстиков и геймпадов — услуга по восстановлению работоспособности игровых контроллеров для консолей и ПК. Даже незначительные сбои могут влиять на игровой процесс, снижать комфорт использования устройства, а также привести к его отказу.</p><h3>Основные виды неисправностей</h3><p>Чаще всего пользователи сталкиваются с типовыми неисправностями, которые требуют замены или восстановления отдельных компонентов. Основные виды поломок:</p><ul><li><b>Дрифт аналоговых стиков.</b> Это приводит к тому, что персонаж или курсор двигается самопроизвольно. Причина кроется в износе потенциометров или загрязнении внутренних элементов. В процессе ремонта выполняется чистка или замена стиков на новые.</li><li><b>Залипание и отказ кнопок.</b> Это связано с износом контактных площадок или попаданием пыли и влаги. Специалисты разбирают устройство, очищают контакты или устанавливают новые элементы. Это гарантирует четкость и быстроту отклика.</li><li><b>Проблемы с питанием и подключением.</b> Причиной могут быть поврежденный разъем, неисправный аккумулятор или плата. В сервисе проводится диагностика всех цепей питания с последующим устранением неполадок.</li></ul><p>После ремонта проводится тестовая проверка, которая должна показать, что геймпад (джойстик) полностью восстановлен и готов к дальнейшей эксплуатации.</p><h3>Преимущества профессионального ремонта</h3><p>Джойстики и геймпады — технически сложные устройства, поэтому ремонтом должны заниматься профессионалы. Это дает следующие преимущества:</p><ul><li>точная диагностика — специалисты безошибочно определяют реальную причину поломки, что позволяет устранить ее с минимумом расходов;</li><li>использование качественных комплектующих — по желанию клиента устанавливаются фирменные детали или сертифицированные аналоги;</li><li>официальная гарантия — она распространяется на установленные детали и выполненные работы.</li></ul><p>Обращение к профессионалам — это проверенный способ вернуть устройству работоспособность без рисков и лишних расходов.</p>";

            $textHeadphones = "<h2>Ремонт наушников</h2><p>Ремонт наушников предусматривает восстановление работоспособности моделей любого типа: кабельных, беспроводных, накладных и внутриканальных моделей. Замена устройства не всегда оправдана, поскольку большинство неисправностей можно устранить. Профессиональный ремонт позволяет вернуть наушникам исходные характеристики и продлить срок службы.</p><h3>Причины поломок наушников</h3><p>Устройства часто выходят из строя из-за неаккуратности пользователей и несоблюдения правил эксплуатации. Основные причины неисправностей:</p><ul><li><b>Механические поломки.</b> Частые перегибы кабеля, падения, сдавливания приводят к обрывам проводов и повреждению корпуса. Нарушение целостности элементов приводит к пропаданию или искажению звука.</li><li><b>Попадание влаги и загрязнений внутрь корпуса.</b> Это приводит к ухудшению звучания, появлению посторонних шумов или снижению громкости. Особенно уязвимы компактные внутриканальные модели.</li><li><b>Износ электронных компонентов.</b> В беспроводных наушниках со временем снижается емкость аккумулятора, возникают сбои в работе плат. Также могут выходить из строя микрофоны и модули связи.</li></ul><p>К серьезным поломкам приводят также попытки самостоятельного ремонта и обслуживания неисправных наушников.</p><h3>Этапы ремонта</h3><p>Процесс ремонта может зависеть от особенностей конкретной поломки и модели наушников, но обычно он проходит по следующему алгоритму:</p><ul><li>Диагностика устройства. Специалисты проводят комплексную проверку наушников с использованием профессионального оборудования.</li><li>Разборка и устранение дефекта. Выполняется очистка, ремонт или замена поврежденных элементов. Все работы проводятся с учетом конструктивных особенностей модели.</li><li>Тестирование и сборка. После завершения ремонта и сборки наушники проходят проверку. Оценивается качество звука, стабильность соединений и работа дополнительных функций.</li></ul><p>На предоставленные услуги, включая установленные компоненты, оформляется гарантия.</p>";

            $textSpeakers = "<h2>Ремонт портативных колонок</h2><p>Профессиональный ремонт портативной колонки позволяет полностью восстановить работоспособность устройства. Это продлит срок его службы и избавит от необходимости покупки нового девайса.</p><h3>Типичные неисправности</h3><p>Поломки портативных колонок могут быть связаны как с механическими повреждениями, так и с износом электронных компонентов. Основные неисправности:</p><ul><li><b>Проблемы со звуком.</b> Колонка может «хрипеть», терять громкость или воспроизводить звук только частично. Причиной часто становятся поврежденные динамики или загрязнение внутренних элементов. Иногда проблема связана с усилителем или платой управления.</li><li><b>Неисправности аккумулятора.</b> Со временем батарея теряет емкость, из-за чего колонка быстро разряжается или не включается. Также возможны проблемы с контроллером питания.</li><li><b>Сбои подключения и управления.</b> Колонка может не подключаться по Bluetooth или терять связь с источником звука. Иногда перестают работать кнопки управления или разъемы.</li></ul><p>Многие неисправности способны прогрессировать и приводить к поломкам других компонентов, поэтому устранять их нужно своевременно и только в специализированном сервисном центре.</p><h3>Почему нельзя делать ремонт самостоятельно</h3><p>Попытки кустарного вмешательства часто заканчиваются дополнительными повреждениями. Основные причины отказаться от самостоятельного ремонта:</p><ul><li>Риск повреждения электроники. Внутри колонки расположены чувствительные элементы, которые легко вывести из строя. Неправильное вскрытие корпуса или неаккуратная пайка могут повредить плату.</li><li>Отсутствие точной диагностики. Без специального оборудования сложно определить истинную причину неисправности.</li><li>Использование неподходящих деталей. Важно учитывать их совместимость с конкретной колонкой.</li></ul><p>Профессиональный ремонт обеспечивает надежный результат и продлевает срок службы устройства без лишних рисков.</p>";

            $textCameras = "<h2>Ремонт фотоаппаратов</h2><p>Современные фотоаппараты — сложные электронно-технические устройства, поэтому устранение любых сбоев требует профессионального подхода. Квалифицированный ремонт позволяет сохранить функциональность техники и избежать затрат на покупку новой камеры.</p><h3>Типичные поломки фотоаппаратов</h3><p>Большинство неполадок поддаются ремонту при условии своевременного обращения в сервис. Основные неисправности:</p><ul><li>Проблемы с объективом. Он может заклинивать, не фокусироваться или выдавать ошибку при включении. Часто причиной становятся механические повреждения или попадание пыли внутрь. Нарушается работа автофокуса и стабилизации изображения.</li><li>Поломки матрицы. На снимках могут появляться пятна, полосы или искажения. Это связано с загрязнением сенсора или его повреждением. Иногда причиной являются сбои в обработке сигнала.</li><li>Сбои в работе электроники. Фотоаппарат может не включаться, зависать или некорректно реагировать на команды. Возможны проблемы с дисплеем, кнопками или платой управления.</li></ul><p>В подобных ситуациях требуется срочное обращение в сервис, поскольку неполадки могут прогрессировать — это увеличит стоимость ремонта.</p><h3>Основные этапы ремонта</h3><p>Алгоритм действий может зависеть от конкретной модели фотоаппарата и специфики неисправностей. Основные этапы:</p><ul><li>Комплексная диагностика с использованием профессионального оборудования. Проверяются оптика, электроника и механика.</li><li>Разборка, дефектовка, замена неисправных компонентов. Работы выполняются с учетом техрегламентов и стандартов производителя, с применением сертифицированных запчастей.</li><li>Сборка и итоговое тестирование. Оценивается качество съемки, работа автофокуса и корректность всех функций (включая дополнительные).</li></ul><p>Профессиональный ремонт обеспечивает полное восстановление работоспособности фотоаппарата и его заявленного функционала. Предоставляется официальная гарантия.</p>";

            $textLenses = "<h2>Ремонт объективов</h2><p>В состав современных объективов входят группы линз, приводы автофокуса и электронные модули, работающие с высокой точностью. Это деликатная техника, требующая предельно аккуратного обращения, поэтому любые неисправности должны устраняться специалистами.</p><h3>Причины поломок объективов</h3><p>Неисправности возникают из-за небрежного обращения, несоблюдения рекомендаций производителя, естественного износа компонентов. Основные причины поломок:</p><ul><li><b>Механические повреждения.</b> Падения, удары или сильные вибрации могут нарушить геометрию корпуса и сместить линзовые группы. Это приводит к потере резкости, заклиниванию зума или фокусировочного кольца. Иногда повреждаются внутренние направляющие и шестерни.</li><li><b>Нарушение калибровки и юстировки.</b> Со временем или после неудачного вмешательства может сбиться точная настройка линзовых групп. Это проявляется в виде неверного фокуса, потери резкости по краям кадра.</li><li><b>Попадание пыли и влаги.</b> Загрязнения проникают внутрь корпуса и оседают на линзах или датчиках. Это вызывает появление пятен, снижение контрастности и проблемы с автофокусом. Влага может дополнительно повредить электронные компоненты.</li></ul><p>Возможен естественный износ моторов автофокуса и стабилизации. Объектив начинает медленно фокусироваться или издавать посторонние звуки. Возможны сбои в передаче данных между объективом и камерой.</p><h3>Преимущества ремонта в профессиональном сервисе</h3><p>Качественный ремонт объективов возможен только при наличии специального оборудования и сертифицированных комплектующих, а также профильных знаний и навыков. Преимущества обращения в сервис:</p><ul><li>точная диагностика с использованием приборов для проверки оптики и механики;</li><li>качественные запчасти от известных производителей;</li><li>официальная гарантия на работы и детали.</li></ul><p>Профессиональный ремонт объективов позволяет сохранить качество съемки и продлить срок службы техники.</p>";

            $textFlashes = "<h2>Ремонт фотовспышек</h2><p>Фотовспышка — источник импульсного света, обеспечивающий правильную экспозицию и детализацию снимков в условиях недостаточного освещения. Современные модели отличаются сложным устройством, поэтому ремонтировать их можно только в сервисном центре.</p><h3>Типичные неисправности фотовспышек</h3><p>Нарушения в работе вспышек могут быть связаны как с электронными компонентами, так и с механическими элементами конструкции. Основные неисправности:</p><ul><li>Отказ срабатывания импульса. Причиной может быть выход из строя конденсатора или цепей питания. Иногда проблема связана с повреждением платы управления.</li><li>Нестабильная работа и перепады мощности. Импульс может быть слишком слабым или, наоборот, чрезмерно ярким. Часто причина кроется в сбоях системы управления или деградации элементов питания.</li><li>Проблемы с синхронизацией. Вспышка срабатывает с задержкой или не синхронизируется с затвором камеры. Это может быть связано с повреждением контактов или нарушением работы интерфейса. Также возможны ошибки в работе беспроводных модулей.</li></ul><p>Своевременный ремонт позволяет устранить неполадки быстро и с минимумом расходов.</p><h3>Основные этапы ремонта фотовспышек</h3><p>Процесс требует точного соблюдения технологических регламентов и применения специализированного оборудования. Основные этапы:</p><ul><li>Диагностика фотовспышки. Специалисты проверяют работоспособность всех узлов, включая электронику и механические элементы. Проводится тестирование импульса, питания и синхронизации.</li><li>Разборка и восстановление компонентов. Поврежденные детали заменяются. При необходимости выполняется очистка контактов и внутренних элементов.</li><li>Сборка и тестирование. Оцениваются стабильность импульса, точность срабатывания и общая работоспособность.</li></ul><p>Профессиональный ремонт полностью восстанавливает работоспособность фотовспышек и продлевает срок их службы.</p>";

            $textComputers = "<h2>Ремонт компьютеров</h2><p>Поломка компьютера может серьезно помешать работе и учебе или испортить домашний отдых. Сервисный центр «Свой Мастер» в Екатеринбурге выполняет ремонт стационарных ПК любых конфигураций. Опыт с 2010 года позволяет нам находить решения даже в сложных случаях.</p><h3>Как проходит ремонт</h3><p>Мастер подключает диагностическое оборудование, выявляет причину, озвучивает стоимость. Ремонт может выполняться в присутствии клиента. После завершения компьютер проходит тестирование под нагрузкой. Даем гарантию 2 года.</p><h3>Преимущества обращения:</h3><ul><li><b>Бесплатная диагностика.</b> Оплата только за ремонт.</li><li><b>Качественные комплектующие.</b> Оригиналы и лицензионные аналоги.</li><li><b>Безопасность.</b> Сохранение всех данных на диске.</li></ul><h3>Типичные неисправности</h3><p><b>Компьютер не включается.</b> Причин несколько: неисправный блок питания, короткое замыкание на материнской плате, проблемы с кнопкой включения. Мастер проверяет оборудование тестером, осматривает на предмет вздутых конденсаторов или следов КЗ.</p><p><b>Синий экран, перезагрузки, зависания.</b> Чаще всего проблема в оперативной памяти, жестком диске или перегреве. Специалист проводит стресс-тест, проверяет температуру процессора и видеокарты, тестирует оперативную память и накопитель. При перегреве чистит систему охлаждения, заменяет термопасту.</p><p><b>Компьютер шумит, быстро выключается.</b> Шум обычно исходит от кулеров — они забиты пылью или износились. Мастер чистит радиаторы, вентиляторы, при необходимости заменяет кулер.</p><p><b>Не включается монитор (при работающем системном блоке).</b> Проблема может быть в видеокарте, кабеле или самом дисплее. Специалист проверяет подключение, тестирует видеокарту на другом мониторе.</p><p>При любых проблемах звоните: +7 (343) 226-46-22.</p>";

            $textMonitors = "<h2>Ремонт мониторов</h2><p>Мониторы компьютеров подвержены различным проблемам, которые могут быть вызваны аппаратными неисправностями, внешними факторами, ошибками эксплуатации или программным обеспечением. Сервисный центр «Свой Мастер» в Екатеринбурге выполняет ремонт моделей любых брендов: LG, Samsung, Dell, Philips, AOC и др.</p><h3>Как мы работаем</h3><p>Первый шаг — бесплатная диагностика. Мастер подключает монитор к источнику сигнала, проверяет работу матрицы, подсветки, контроллера. Ремонт выполняется в присутствии клиента (от 30 минут до 2 часов). После завершения монитор проходит тестирование на всех режимах.</p><h3>Почему выбирают «Свой Мастер»:</h3><ul><li><b>Прозрачные условия.</b> Договор до начала работ.</li><li><b>Качественные комплектующие.</b> Оригинальные и совместимые детали.</li><li><b>Гарантия до двух лет.</b> На работы и установленные компоненты.</li></ul><h3>С чем к нам приходят</h3><p><b>Нет изображения, но есть подсветка или индикатор питания горит.</b> Проблема часто в шлейфе матрицы или материнской плате монитора. В большинстве случаев требуется замена контроллера или перепайка разъема.</p><p><b>Изображение есть, но мерцает, появляются полосы или пятна.</b> Горизонтальные линии с большой вероятностью означают проблемы шлейфа, вертикальные — чаще дефект матрицы, которая не ремонтируется, а заменяется целиком. Темные пятна на экране — повреждение подсветки.</p><p><b>Монитор не включается, индикатор не горит.</b> Вероятные причины: неисправный блок питания (внешний или встроенный), пробой конденсаторов на плате, выход из строя контроллера питания. Специалист проверяет входные цепи, заменяет поврежденные компоненты.</p><p><b>Подсветка не работает, но изображение видно (очень темное).</b> Проблема в инверторе или светодиодной ленте. Мастер диагностирует блок подсветки, заменяет вышедшие из строя элементы.</p><p>По любым вопросам обращайтесь к нам по телефону: +7 (343) 226-46-22.</p>";

            $textMonoblocks = "<h2>Ремонт моноблоков</h2><p>Моноблок — компьютер, объединенный с монитором в одном корпусе. Он компактен, но его восстановление сложнее, чем обычного системника. Сервисный центр «Свой Мастер» в Екатеринбурге выполняет ремонт моноблоков различных брендов (Apple iMac, HP, Lenovo, Dell, Acer). Решаем задачи любой сложности.</p><h3>Самые частые проблемы</h3><p><b>Не включается, нет реакции на кнопку.</b> Возможные причины: неисправный блок питания, короткое замыкание на материнской плате, проблемы с клавишей включения. В моноблоках доступ к компонентам затруднен — корпус часто склеен или зафиксирован специальными винтами. Мастер аккуратно вскрывает устройство, проверяет блок питания, осматривает плату.</p><p><b>Изображение мерцает, появились полосы, нет подсветки.</b> Причина может быть в шлейфе, контроллере или в самой матрице. Специалист диагностирует каждый узел. Замена матрицы — одна из самых сложных операций: требуется подобрать совместимый модуль и аккуратно установить его.</p><p><b>Перегрев, шум кулера, внезапное выключение.</b> Моноблоки греются сильнее из-за компактной компоновки. Мастер разбирает устройство, чистит радиатор и вентилятор, заменяет термопасту. Если кулер шумит, скорее всего, износился подшипник, потребуется замена.</p><p><b>Не работают USB-порты, Wi-Fi, Bluetooth.</b> Проблема либо в драйверах, либо в самом модуле. Специалист проверяет программную часть, при необходимости заменяет беспроводной адаптер или контроллер портов.</p><h3>Как проходит ремонт</h3><p>Бесплатная диагностика — обязательный этап. Мастер подключает оборудование, выявляет причину, озвучивает стоимость. Условия фиксируются в договоре. Ремонт занимает от 1 до 4 часов в зависимости от сложности. Клиент может наблюдать за процессом. После завершения моноблок проходит тестирование всех функций. Гарантия — до двух лет. Для консультации звоните: +7 (343) 226-46-22.</p>";

            $textTVs = "<h2>Ремонт телевизоров</h2><p>Современный телевизор — сложное электронное устройство. Когда он выходит из строя, восстановить работоспособность без специального оборудования, знаний и навыков практически невозможно. Сервисный центр «Свой Мастер» в ЕКБ выполняет ремонт ТВ-приемников любых брендов, предоставляем гарантию до двух лет.</p><h3>Почему нам доверяют:</h3><ul><li><b>Бесплатная диагностика.</b> Вы оплачиваете только ремонт.</li><li><b>Прозрачные условия.</b> Договор заключается до начала работ.</li><li><b>Качественные комплектующие.</b> Используем только сертифицированные запчасти.</li></ul><h3>С чем мы работаем</h3><p><b>Телевизор не включается, индикатор не горит или мигает.</b> Проблема чаще всего в блоке питания. Мастер проверяет входные цепи, конденсаторы, диодный мост. Замена блока питания или его компонентов восстанавливает работоспособность.</p><p><b>Нет изображения, звук есть.</b> Экран черный, но телевизор реагирует на пульт. Вероятные причины: неисправна подсветка (LED-ленты) или вышел из строя контроллер матрицы. Специалист проверяет тестером. Если ленты перегорели — требуется замена. Это трудоемкая операция: нужно аккуратно разобрать матрицу, не повредив ее.</p><p><b>Появились полосы, пятна, мерцание.</b> Линии часто указывают на неисправность матрицы или ее шлейфа. Горизонтальные во многих случаях удается устранить восстановлением контакта. Вертикальные обычно требуют замены матрицы, что экономически нецелесообразно для недорогих моделей. Темные пятна указывают на выгорание или повреждение подсветки.</p><p><b>Телевизор сам выключается, перезагружается.</b> Причина может быть в перегреве процессора или неисправности блока питания. Мастер проверяет температуру компонентов, чистит систему охлаждения.</p><p>После завершения телевизор проходит тестирование на всех режимах.</p>";

            $textConsoles = "<h2>Ремонт игровых приставок</h2><p>Игровые консоли работают под высокими нагрузками, что часто приводит к перегреву, выходу из строя блока питания, проблемам с дисководом или накопителем. Сервисный центр «Свой Мастер» в Екатеринбурге выполняет ремонт приставок любых моделей. Наши инженеры работают с 2010 года, используют профессиональное оборудование для пайки и тестирования.</p><h3>Самые частые неисправности</h3><p><b>Приставка не включается, нет реакции на кнопку.</b> Причины: короткое замыкание на материнской плате, проблемы с кнопкой включения и др. Мастер проверяет блок питания тестером, осматривает оборудование на предмет вздутых конденсаторов.</p><p><b>Перегрев, шум кулера, внезапное выключение.</b> Частая предпосылка — забитая пылью система охлаждения. Специалист разбирает консоль, чистит радиатор и вентилятор, заменяет термопасту на процессоре. Если кулер издает скрежет — требуется замена.</p><p><b>Не читает диски, дисковод шумит.</b> Проблема в лазере или механике дисковода. Мастер диагностирует привод. При необходимости заменяет лазерную головку или весь дисковод в сборе.</p><p><b>Ошибки при запуске игр, зависания.</b> Причина может быть в жестком диске (HDD) или твердотельном накопителе (SSD). Специалист проверяет данное оборудование, при необходимости заменяет его и устанавливает системное ПО. Также возможны проблемы с оперативной памятью или графическим чипом — в этом случае потребуется пайка.</p><p><b>Не работают порты USB, HDMI, беспроводные контроллеры.</b> Разъем — одно из уязвимых мест при частом переключении кабелей. Мастер перепаивает порт или заменяет контроллер.</p><h3>Как проходит ремонт</h3><p>Вначале выполняется бесплатная диагностика. Специалист подключает приставку, выявляет причину, озвучивает стоимость. Условия фиксируются в договоре.</p><p>Работа производится в присутствии клиента (от 1 до 3 часов). После завершения приставка проходит тестирование в игровом режиме. Гарантия — до двух лет.</p><p>Чтобы записаться на ремонт, звоните +7 (343) 226-46-22.</p>";

            // ЛОГИКА ОБНОВЛЕНИЯ
            // Категория "Ремонт планшетов" (remont-planshetov):
            $tabletCategory = Category::where('slug', 'remont-planshetov')->first();
            if ($tabletCategory) {
                $brandsInTabletCategory = Brand::whereHas('models', function ($q) use ($tabletCategory) {
                        $q->where('category_id', $tabletCategory->id);
                    })->orWhereHas('categories', function ($q) use ($tabletCategory) {
                        $q->where('categories.id', $tabletCategory->id);
                    })->get();

                foreach ($brandsInTabletCategory as $b) {
                    if ($b->slug === 'huawei') {
                        BrandCategorySeoText::updateOrCreate(
                            ['brand_id' => $b->id, 'category_id' => $tabletCategory->id],
                            ['seo_bottom_text' => $textTabletHuawei]
                        );
                    } elseif ($b->slug === 'honor') {
                        BrandCategorySeoText::updateOrCreate(
                            ['brand_id' => $b->id, 'category_id' => $tabletCategory->id],
                            ['seo_bottom_text' => $textTabletHonor]
                        );
                    } else {
                        BrandCategorySeoText::updateOrCreate(
                            ['brand_id' => $b->id, 'category_id' => $tabletCategory->id],
                            ['seo_bottom_text' => $textTabletBrand]
                        );
                    }
                }
            }

            // Категория "Ремонт ноутбуков" (remont-noutbukov):
            $laptopsCategory = Category::where('slug', 'remont-noutbukov')->first();
            if ($laptopsCategory) {
                $laptopsCategory->update(['seo_bottom_text' => $textLaptopsCategory]);

                $appleBrandInLaptops = Brand::where('slug', 'apple')->first();
                if ($appleBrandInLaptops) {
                    BrandCategorySeoText::updateOrCreate(
                        ['brand_id' => $appleBrandInLaptops->id, 'category_id' => $laptopsCategory->id],
                        ['seo_bottom_text' => $textMacbookBrand]
                    );

                    DeviceModel::where('category_id', $laptopsCategory->id)
                        ->where('brand_id', $appleBrandInLaptops->id)
                        ->update(['seo_bottom_text' => $textMacbookModel]);
                }
            }

            // Категория "Ремонт смарт-часов" (remont-smart-chasov):
            $smartWatchCategory = Category::where('slug', 'remont-smart-chasov')->first();
            if ($smartWatchCategory) {
                $smartWatchCategory->update(['seo_bottom_text' => $textSmartWatchCategory]);

                $appleBrandInSmartWatch = Brand::where('slug', 'apple')->first();
                if ($appleBrandInSmartWatch) {
                    BrandCategorySeoText::updateOrCreate(
                        ['brand_id' => $appleBrandInSmartWatch->id, 'category_id' => $smartWatchCategory->id],
                        ['seo_bottom_text' => $textAppleWatchBrand]
                    );

                    DeviceModel::where('category_id', $smartWatchCategory->id)
                        ->where('brand_id', $appleBrandInSmartWatch->id)
                        ->update(['seo_bottom_text' => $textAppleWatchModel]);
                }
            }

            // Остальные категории (текст на страницах самих категорий)
            $categorySeoTexts = [
                'remont-dzhojstikov' => $textJoysticks,
                'remont-naushnikov' => $textHeadphones,
                'remont-portativnyh-kolonok' => $textSpeakers,
                'remont-fotoapparatov' => $textCameras,
                'remont-obektivov' => $textLenses,
                'remont-fotovspyshek' => $textFlashes,
                'remont-komputerov' => $textComputers,
                'remont-monitorov' => $textMonitors,
                'remont-monoblokov' => $textMonoblocks,
                'remont-televizorov' => $textTVs,
                'remont-pristavok' => $textConsoles,
            ];

            foreach ($categorySeoTexts as $categorySlug => $seoText) {
                Category::where('slug', $categorySlug)->update(['seo_bottom_text' => $seoText]);
            }

        // ─── Итого ───
        $this->command->info('');
        $this->command->info('═══ ИТОГО ═══');
        $this->command->info('Категории:     ' . Category::count());
        $this->command->info('Бренды:        ' . Brand::count());
        $this->command->info('Модели:        ' . DeviceModel::count());
        $this->command->info('Услуги:        ' . Service::count());
        $this->command->info('Посадочные:    ' . LandingPage::count());
        $this->command->info('ServiceScopes: ' . ServiceScope::count());
        $this->command->info('Поломки:       ' . Defect::count());
        $this->command->info('');
        $this->command->info('✅ Сидер выполнен успешно!');
    }
}