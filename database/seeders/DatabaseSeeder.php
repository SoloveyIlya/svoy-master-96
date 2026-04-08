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
            ['name'=>'Замена корпуса (верхней/нижней крышки)', 'slug'=>'zamena-korpusa', 'cats'=>['remont-noutbukov']],
        ];

        // Создаём все базовые услуги и храним в ассоц. массиве по slug
        $serviceMap = []; // slug => Service model
        $serviceCats = []; // slug => ['remont-telefonov', ...]

        foreach ($servicesData as $svc) {
            $service = Service::create([
                'name'          => $svc['name'],
                'slug'          => $svc['slug'],
                'price_from'    => '1000',
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
                    DB::table('category_service')->insertOrIgnore([
                        'category_id' => $category->id,
                        'service_id'  => $svcObj->id,
                        'created_at'  => now(),
                        'updated_at'  => now(),
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
                        ServiceScope::updateOrCreate(
                            [
                                'scope_type' => 'brand',
                                'scope_id'   => $brand->id,
                                'service_id' => $svcObj->id,
                            ],
                            [
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
                                LandingPage::create([
                                    'category_id' => $category->id,
                                    'brand_id'    => $brand->id,
                                    'model_id'    => $model->id,
                                    'service_id'  => $svcObj->id,
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
                'diagnostika'=>'Диагностика компьютера', 'zamena-bloka-pitaniya'=>'Замена блока питания', 'zamena-materinskoj-platy'=>'Замена материнской платы', 'zamena-operativnoj-pamyati'=>'Замена оперативной памяти', 'zamena-videokarty'=>'Замена видеокарты', 'zamena-hdd-ssd'=>'Замена жесткого диска (HDD/SSD)', 'chistka-ot-pyli'=>'Чистка от пыли', 'zamena-termopasty'=>'Замена термопасты', 'ustanovka-windows'=>'Установка Windows', 'vosstanovlenie-dannyh'=>'Восстановление данных'
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
                // Услуга может уже существовать из базового списка или другой категории
                $service = Service::firstOrCreate(
                    ['slug' => $svcSlug],
                    [
                        'name'          => $svcName,
                        'price_from'    => '1000',
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

        // Категории — оставляем в поле seo_bottom_text на самой модели (без категориальной привязки)
        Category::where('slug', 'remont-telefonov')->update(['seo_bottom_text' => $phonesText]);
        Category::where('slug', 'remont-planshetov')->update(['seo_bottom_text' => $tabletsText]);

        // Бренды — тексты привязаны к категории remont-telefonov через отдельную таблицу
        $phoneCategoryId = Category::where('slug', 'remont-telefonov')->value('id');

        $brandSeoTexts = [
            'apple'   => $appleText,
            'samsung' => $samsungText,
            'xiaomi'  => $xiaomiText,
            'honor'   => $honorText,
            'huawei' => $huaweiText,
            'google-pixel' => $googlePixelText,
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

        $this->command->info('  ✓ SEO-тексты добавлены: 2 категории + 4 бренда (категория: Телефоны)');

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