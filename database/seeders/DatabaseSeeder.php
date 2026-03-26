<?php

namespace Database\Seeders;

use App\Models\Brand;
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
                'name'   => $svc['name'],
                'slug'   => $svc['slug'],
                'status' => 'active',
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
                'brands' => [
                    'apple' => ['name' => 'Apple', 'models' => [
                        'iphone-se'=>'iPhone SE','iphone-11'=>'iPhone 11','iphone-11-pro'=>'iPhone 11 Pro','iphone-11-pro-max'=>'iPhone 11 Pro Max','iphone-12'=>'iPhone 12','iphone-12-mini'=>'iPhone 12 mini','iphone-12-pro'=>'iPhone 12 Pro','iphone-12-pro-max'=>'iPhone 12 Pro Max','iphone-13'=>'iPhone 13','iphone-13-mini'=>'iPhone 13 mini','iphone-13-pro'=>'iPhone 13 Pro','iphone-13-pro-max'=>'iPhone 13 Pro Max','iphone-14'=>'iPhone 14','iphone-14-plus'=>'iPhone 14 Plus','iphone-14-pro'=>'iPhone 14 Pro','iphone-14-pro-max'=>'iPhone 14 Pro Max','iphone-15'=>'iPhone 15','iphone-15-plus'=>'iPhone 15 Plus','iphone-15-pro'=>'iPhone 15 Pro','iphone-15-pro-max'=>'iPhone 15 Pro Max','iphone-16e'=>'iPhone 16e','iphone-16'=>'iPhone 16','iphone-16-plus'=>'iPhone 16 Plus','iphone-16-pro'=>'iPhone 16 Pro','iphone-16-pro-max'=>'iPhone 16 Pro Max','iphone-17e'=>'iPhone 17e','iphone-17'=>'iPhone 17','iphone-17-air'=>'iPhone 17 Air','iphone-17-pro'=>'iPhone 17 Pro','iphone-17-pro-max'=>'iPhone 17 Pro Max'
                    ]],
                    'samsung' => ['name' => 'Samsung', 'models' => [
                        'galaxy-a12'=>'Galaxy A12','galaxy-a13'=>'Galaxy A13','galaxy-a14'=>'Galaxy A14','galaxy-a15'=>'Galaxy A15','galaxy-a25'=>'Galaxy A25','galaxy-a35'=>'Galaxy A35','galaxy-a55'=>'Galaxy A55','galaxy-s21'=>'Galaxy S21','galaxy-s21-plus'=>'Galaxy S21 Plus','galaxy-s21-ultra'=>'Galaxy S21 Ultra','galaxy-s22'=>'Galaxy S22','galaxy-s22-plus'=>'Galaxy S22 Plus','galaxy-s22-ultra'=>'Galaxy S22 Ultra','galaxy-s23'=>'Galaxy S23','galaxy-s23-plus'=>'Galaxy S23 Plus','galaxy-s23-ultra'=>'Galaxy S23 Ultra','galaxy-s24'=>'Galaxy S24','galaxy-s24-plus'=>'Galaxy S24 Plus','galaxy-s24-ultra'=>'Galaxy S24 Ultra','galaxy-z-flip4'=>'Galaxy Z Flip4','galaxy-z-flip5'=>'Galaxy Z Flip5','galaxy-z-flip6'=>'Galaxy Z Flip6','galaxy-z-fold4'=>'Galaxy Z Fold4','galaxy-z-fold5'=>'Galaxy Z Fold5','galaxy-z-fold6'=>'Galaxy Z Fold6'
                    ]],
                    'xiaomi' => ['name' => 'Xiaomi', 'models' => [
                        'redmi-note-10'=>'Redmi Note 10','redmi-note-10-pro'=>'Redmi Note 10 Pro','redmi-note-11'=>'Redmi Note 11','redmi-note-11-pro'=>'Redmi Note 11 Pro','redmi-note-12'=>'Redmi Note 12','redmi-note-12-pro'=>'Redmi Note 12 Pro','redmi-note-13'=>'Redmi Note 13','redmi-note-13-pro'=>'Redmi Note 13 Pro','redmi-12c'=>'Redmi 12C','redmi-13c'=>'Redmi 13C','poco-x3-pro'=>'Poco X3 Pro','poco-x5-pro'=>'Poco X5 Pro','poco-f5'=>'Poco F5','mi-11'=>'Mi 11','mi-11-lite'=>'Mi 11 Lite','xiaomi-12'=>'Xiaomi 12','xiaomi-12-pro'=>'Xiaomi 12 Pro','xiaomi-13'=>'Xiaomi 13','xiaomi-13-pro'=>'Xiaomi 13 Pro','xiaomi-14'=>'Xiaomi 14','xiaomi-14-ultra'=>'Xiaomi 14 Ultra'
                    ]],
                    'honor' => ['name' => 'Honor', 'models' => [
                        'honor-50'=>'Honor 50','honor-50-lite'=>'Honor 50 Lite','honor-70'=>'Honor 70','honor-80'=>'Honor 80','honor-90'=>'Honor 90','honor-90-lite'=>'Honor 90 Lite','honor-200'=>'Honor 200','honor-200-pro'=>'Honor 200 Pro','honor-magic-5-pro'=>'Honor Magic 5 Pro','honor-magic-6-pro'=>'Honor Magic 6 Pro','honor-x7'=>'Honor X7','honor-x8'=>'Honor X8','honor-x9'=>'Honor X9','honor-x9b'=>'Honor X9b'
                    ]],
                    'huawei' => ['name' => 'Huawei', 'models' => [
                        'p30'=>'Huawei P30','p30-pro'=>'Huawei P30 Pro','p40'=>'Huawei P40','p40-pro'=>'Huawei P40 Pro','p50'=>'Huawei P50','p50-pro'=>'Huawei P50 Pro','p60'=>'Huawei P60','p60-pro'=>'Huawei P60 Pro','mate-30'=>'Huawei Mate 30','mate-30-pro'=>'Huawei Mate 30 Pro','mate-40-pro'=>'Huawei Mate 40 Pro','mate-50-pro'=>'Huawei Mate 50 Pro','mate-60-pro'=>'Huawei Mate 60 Pro','nova-10'=>'Huawei Nova 10','nova-11'=>'Huawei Nova 11','nova-12'=>'Huawei Nova 12','nova-12-pro'=>'Huawei Nova 12 Pro'
                    ]],
                    'google-pixel' => ['name' => 'Google Pixel', 'models' => [
                        'pixel-6'=>'Pixel 6','pixel-6-pro'=>'Pixel 6 Pro','pixel-7'=>'Pixel 7','pixel-7-pro'=>'Pixel 7 Pro','pixel-8'=>'Pixel 8','pixel-8-pro'=>'Pixel 8 Pro','pixel-9'=>'Pixel 9','pixel-9-pro'=>'Pixel 9 Pro','pixel-9-pro-xl'=>'Pixel 9 Pro XL','pixel-9-pro-fold'=>'Pixel 9 Pro Fold','pixel-10'=>'Pixel 10','pixel-10-pro'=>'Pixel 10 Pro','pixel-10-pro-xl'=>'Pixel 10 Pro XL','pixel-10-pro-fold'=>'Pixel 10 Pro Fold'
                    ]],
                    // Бренды без моделей
                    'meizu'=>['name'=>'Meizu'],'zte'=>['name'=>'ZTE'],'lenovo'=>['name'=>'Lenovo'],'asus'=>['name'=>'ASUS'],'sony'=>['name'=>'Sony'],'realme'=>['name'=>'realme'],'oppo'=>['name'=>'Oppo'],'vivo'=>['name'=>'Vivo'],'oneplus'=>['name'=>'OnePlus'],'nokia'=>['name'=>'Nokia'],'motorola'=>['name'=>'Motorola'],'lg'=>['name'=>'LG'],'htc'=>['name'=>'HTC'],'tecno'=>['name'=>'Tecno'],'infinix'=>['name'=>'Infinix'],'poco'=>['name'=>'Poco'],'blackview'=>['name'=>'Blackview'],'ulefone'=>['name'=>'Ulefone'],'doogee'=>['name'=>'Doogee'],'cubot'=>['name'=>'Cubot'],'alcatel'=>['name'=>'Alcatel'],'philips'=>['name'=>'Philips'],'fly'=>['name'=>'Fly'],'dexp'=>['name'=>'DEXP'],'bq'=>['name'=>'BQ'],'texet'=>['name'=>'Texet'],'oukitel'=>['name'=>'Oukitel'],'umidigi'=>['name'=>'Umidigi'],'vertu'=>['name'=>'Vertu']
                ]
            ],
            'remont-planshetov' => [
                'name' => 'Планшеты',
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
                $category = Category::create([
                    'name'      => $catData['name'],
                    'slug'      => $catSlug,
                    'seo_title' => "Ремонт {$catData['name']} в Екатеринбурге — цены, сроки, гарантия",
                    'seo_h1'    => "Ремонт {$catData['name']}",
                    'status'    => 'active',
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
            'remont-komputerov' => ['name' => 'Ремонт компьютеров', 'services' => [
                'diagnostika'=>'Диагностика компьютера', 'zamena-bloka-pitaniya'=>'Замена блока питания', 'zamena-materinskoj-platy'=>'Замена материнской платы', 'zamena-operativnoj-pamyati'=>'Замена оперативной памяти', 'zamena-videokarty'=>'Замена видеокарты', 'zamena-hdd-ssd'=>'Замена жесткого диска (HDD/SSD)', 'chistka-ot-pyli'=>'Чистка от пыли', 'zamena-termopasty'=>'Замена термопасты', 'ustanovka-windows'=>'Установка Windows', 'vosstanovlenie-dannyh'=>'Восстановление данных'
            ]],
            'remont-monitorov' => ['name' => 'Ремонт мониторов', 'services' => [
                'diagnostika'=>'Диагностика монитора', 'zamena-matricy'=>'Замена матрицы', 'zamena-bloka-pitaniya'=>'Замена блока питания', 'remont-podsvetki'=>'Ремонт подсветки', 'zamena-shlejfa'=>'Замена шлейфа', 'remont-materinskoj-platy'=>'Ремонт материнской платы'
            ]],
            'remont-monoblokov' => ['name' => 'Ремонт моноблоков', 'services' => [
                'diagnostika'=>'Диагностика моноблока', 'zamena-matricy'=>'Замена матрицы', 'zamena-hdd-ssd'=>'Замена жесткого диска (HDD/SSD)', 'zamena-operativnoj-pamyati'=>'Замена оперативной памяти', 'zamena-bloka-pitaniya'=>'Замена блока питания', 'chistka-ot-pyli'=>'Чистка от пыли'
            ]],
            'remont-televizorov' => ['name' => 'Ремонт телевизоров', 'services' => [
                'diagnostika'=>'Диагностика телевизора', 'zamena-matricy'=>'Замена матрицы', 'remont-bloka-pitaniya'=>'Ремонт блока питания', 'remont-podsvetki'=>'Ремонт подсветки', 'zamena-shlejfa'=>'Замена шлейфа', 'remont-materinskoj-platy'=>'Ремонт материнской платы', 'obnovlenie-proshivki'=>'Обновление прошивки'
            ]],
            'remont-pristavok' => ['name' => 'Ремонт игровых приставок', 'services' => [
                'diagnostika'=>'Диагностика приставки', 'remont-bloka-pitaniya'=>'Ремонт блока питания', 'zamena-termopasty'=>'Замена термопасты', 'zamena-kulera'=>'Замена кулера (вентилятора)', 'remont-privoda'=>'Ремонт привода (дисковода)', 'pereproshivka'=>'Перепрошивка'
            ]],
            'remont-dzhojstikov' => ['name' => 'Ремонт джойстиков и геймпадов', 'services' => [
                'diagnostika'=>'Диагностика джойстика', 'remont-stika'=>'Ремонт джойстика (стика)', 'remont-drifta'=>'Ремонт кнопок (дрифт)', 'zamena-akkumulyatora'=>'Замена аккумулятора', 'remont-vibromotora'=>'Ремонт вибромотора', 'zamena-razema-zaryadki'=>'Замена разъема зарядки'
            ]],
            'remont-naushnikov' => ['name' => 'Ремонт наушников', 'services' => [
                'diagnostika'=>'Диагностика наушников', 'zamena-razema'=>'Замена разъема (штекера)', 'zamena-akkumulyatora'=>'Замена аккумулятора (беспроводные)', 'zamena-dinamika'=>'Замена динамика (драйвера)', 'zamena-ambushyur'=>'Замена амбушюр', 'remont-platy'=>'Ремонт платы управления'
            ]],
            'remont-portativnyh-kolonok' => ['name' => 'Ремонт портативных колонок', 'services' => [
                'diagnostika'=>'Диагностика колонки', 'zamena-akkumulyatora'=>'Замена аккумулятора', 'zamena-dinamika'=>'Замена динамика', 'zamena-razema-zaryadki'=>'Замена разъема зарядки', 'remont-platy'=>'Ремонт платы управления', 'remont-posle-zalitiya'=>'Ремонт после залития'
            ]],
            'remont-fotoapparatov' => ['name' => 'Ремонт фотоаппаратов', 'services' => [
                'diagnostika'=>'Диагностика фотоаппарата', 'chistka-matricy'=>'Чистка матрицы', 'zamena-zatvora'=>'Замена затвора', 'remont-obektiva'=>'Ремонт объектива', 'zamena-ekrana'=>'Замена дисплея (экрана)', 'zamena-akkumulyatora'=>'Замена аккумулятора'
            ]],
            'remont-obektivov' => ['name' => 'Ремонт объективов', 'services' => [
                'diagnostika'=>'Диагностика объектива', 'chistka-obektiva'=>'Чистка объектива', 'zamena-shesterenok'=>'Замена шестеренок (фокусировка)', 'remont-stabilizatora'=>'Ремонт стабилизатора', 'zamena-diafragmy'=>'Замена диафрагмы', 'remont-bajoneta'=>'Ремонт байонета (крепления)'
            ]],
            'remont-fotovspyshek' => ['name' => 'Ремонт фотовспышек', 'services' => [
                'diagnostika'=>'Диагностика фотовспышки', 'zamena-lampy'=>'Замена лампы (ксенон)', 'remont-kondensatora'=>'Ремонт конденсатора', 'zamena-akkumulyatora'=>'Замена аккумулятора'
            ]],
            'remont-elektronnyh-knig' => ['name' => 'Ремонт электронных книг', 'services' => [
                'diagnostika'=>'Диагностика электронной книги', 'zamena-ekrana'=>'Замена экрана', 'zamena-akkumulyatora'=>'Замена аккумулятора', 'zamena-razema-zaryadki'=>'Замена разъема зарядки', 'obnovlenie-proshivki'=>'Обновление прошивки'
            ]],
            'remont-kvadrokopterov' => ['name' => 'Ремонт квадрокоптеров и дронов', 'services' => [
                'diagnostika'=>'Диагностика дрона', 'zamena-motora'=>'Замена мотора', 'zamena-lopastej'=>'Замена лопастей (пропеллеров)', 'remont-gps'=>'Ремонт GPS-модуля', 'remont-kamery'=>'Ремонт камеры', 'zamena-akkumulyatora'=>'Замена аккумулятора'
            ]],
            'remont-robotov-pylesosov' => ['name' => 'Ремонт роботов-пылесосов', 'services' => [
                'diagnostika'=>'Диагностика робота-пылесоса', 'zamena-akkumulyatora'=>'Замена аккумулятора', 'zamena-shhetok'=>'Замена щеток', 'zamena-koles'=>'Замена колес', 'remont-platy'=>'Ремонт платы управления', 'remont-datchikov'=>'Ремонт датчиков'
            ]],
            'remont-terminalov-sbora-dannyh' => ['name' => 'Ремонт терминалов сбора данных', 'services' => [
                'diagnostika'=>'Диагностика терминала', 'zamena-ekrana'=>'Замена экрана', 'zamena-akkumulyatora'=>'Замена аккумулятора', 'remont-skanera'=>'Ремонт сканера штрихкода', 'zamena-klaviatury'=>'Замена клавиатуры', 'remont-posle-zalitiya'=>'Ремонт после залития'
            ]],
        ];

        foreach ($otherDevicesData as $catSlug => $catData) {
            $category = Category::create([
                'name'      => $catData['name'],
                'slug'      => $catSlug,
                'seo_title' => "{$catData['name']} в Екатеринбурге — цены, сроки, гарантия",
                'seo_h1'    => $catData['name'],
                'status'    => 'active',
            ]);

            foreach ($catData['services'] as $svcSlug => $svcName) {
                // Услуга может уже существовать из базового списка или другой категории
                $service = Service::firstOrCreate(
                    ['slug' => $svcSlug],
                    [
                        'name'   => $svcName,
                        'status' => 'active',
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

        $defectsData = [
            // Телефоны
            ['name'=>'Разбитое стекло', 'slug'=>'razbitoe-steklo', 'service'=>'zamena-stekla', 'cat'=>'remont-telefonov'],
            ['name'=>'Не заряжается', 'slug'=>'ne-zaryazhaetsya', 'service'=>'zamena-razema-zaryadki', 'cat'=>'remont-telefonov'],
            ['name'=>'Быстро разряжается', 'slug'=>'bystro-razryazhaetsya', 'service'=>'zamena-akkumulyatora', 'cat'=>'remont-telefonov'],
            ['name'=>'Попала вода', 'slug'=>'popala-voda', 'service'=>'remont-posle-zalitiya', 'cat'=>'remont-telefonov'],
            ['name'=>'Нет сети', 'slug'=>'net-seti', 'service'=>null, 'cat'=>'remont-telefonov'],
            ['name'=>'Не работает Wi-Fi', 'slug'=>'ne-rabotaet-wi-fi', 'service'=>null, 'cat'=>'remont-telefonov'],
            ['name'=>'Не работает камера', 'slug'=>'ne-rabotaet-kamera', 'service'=>'zamena-kamery', 'cat'=>'remont-telefonov'],
            ['name'=>'Не работает звук', 'slug'=>'ne-rabotaet-zvuk', 'service'=>'zamena-dinamika', 'cat'=>'remont-telefonov'],
            ['name'=>'Не включается', 'slug'=>'ne-vklyuchaetsya', 'service'=>null, 'cat'=>'remont-telefonov'],
            ['name'=>'Тормозит', 'slug'=>'tormozit', 'service'=>'proshivka-po', 'cat'=>'remont-telefonov'],
            ['name'=>'Глючит сенсор', 'slug'=>'glyuchit-sensor', 'service'=>'zamena-ekrana', 'cat'=>'remont-telefonov'],
            ['name'=>'Не работает кнопка включения', 'slug'=>'ne-rabotaet-knopka-vklyucheniya', 'service'=>null, 'cat'=>'remont-telefonov'],
            ['name'=>'Не видит SIM-карту', 'slug'=>'ne-vidit-sim-kartu', 'service'=>null, 'cat'=>'remont-telefonov'],
            ['name'=>'Завис на логотипе', 'slug'=>'zavis-na-logotipe', 'service'=>'proshivka-po', 'cat'=>'remont-telefonov'],
            ['name'=>'Не работает динамик', 'slug'=>'ne-rabotaet-dinamik', 'service'=>'zamena-dinamika', 'cat'=>'remont-telefonov'],
            ['name'=>'Не работает микрофон', 'slug'=>'ne-rabotaet-mikrofon', 'service'=>'zamena-mikrofona', 'cat'=>'remont-telefonov'],
            ['name'=>'Разбита задняя крышка', 'slug'=>'razbita-zadnyaya-kryshka', 'service'=>'zamena-zadnej-kryshki', 'cat'=>'remont-telefonov'],
            ['name'=>'Не работает Face ID', 'slug'=>'ne-rabotaet-face-id', 'service'=>null, 'cat'=>'remont-telefonov'],
            ['name'=>'Не работает сканер отпечатка', 'slug'=>'ne-rabotaet-skaner-otpechatka', 'service'=>null, 'cat'=>'remont-telefonov'],

            // Планшеты (Уникальные)
            ['name'=>'Не работает кнопка', 'slug'=>'ne-rabotaet-knopka', 'service'=>null, 'cat'=>'remont-planshetov'],
            ['name'=>'Не работает разъем наушников', 'slug'=>'ne-rabotaet-razem-naushnikov', 'service'=>null, 'cat'=>'remont-planshetov'],

            // Ноутбуки
            ['name'=>'Разбита матрица', 'slug'=>'razbita-matrica', 'service'=>'zamena-matricy', 'cat'=>'remont-noutbukov'],
            ['name'=>'Не работает клавиатура', 'slug'=>'ne-rabotaet-klaviatura', 'service'=>'zamena-klaviatury', 'cat'=>'remont-noutbukov'],
            ['name'=>'Сильно греется', 'slug'=>'silno-greetsya', 'service'=>'chistka-ot-pyli', 'cat'=>'remont-noutbukov'],
            ['name'=>'Сильно шумит', 'slug'=>'silno-shumit', 'service'=>'chistka-ot-pyli', 'cat'=>'remont-noutbukov'],
            ['name'=>'Зависает', 'slug'=>'zavisaet', 'service'=>'ustanovka-windows', 'cat'=>'remont-noutbukov'],
            ['name'=>'Не работает тачпад', 'slug'=>'ne-rabotaet-tachpad', 'service'=>'zamena-tachpada', 'cat'=>'remont-noutbukov'],
            ['name'=>'Не видит жесткий диск', 'slug'=>'ne-vidit-zhestkij-disk', 'service'=>'zamena-hdd-ssd', 'cat'=>'remont-noutbukov'],
            ['name'=>'Сломан разъем зарядки', 'slug'=>'sloman-razem-zaryadki', 'service'=>'zamena-razema-zaryadki', 'cat'=>'remont-noutbukov'],
            ['name'=>'Не включается экран', 'slug'=>'ne-vklyuchaetsya-ekran', 'service'=>'zamena-matricy', 'cat'=>'remont-noutbukov'],
            ['name'=>'Трещина на корпусе', 'slug'=>'treshhina-na-korpuse', 'service'=>'zamena-korpusa', 'cat'=>'remont-noutbukov'],
            ['name'=>'Сломаны петли крышки', 'slug'=>'slomany-petli-kryshki', 'service'=>'zamena-petel', 'cat'=>'remont-noutbukov'],

            // Смарт-часы
            ['name'=>'Нет связи с телефоном', 'slug'=>'net-svyazi-s-telefonom', 'service'=>null, 'cat'=>'remont-smart-chasov'],
            ['name'=>'Не работают датчики', 'slug'=>'ne-rabotayut-datchiki', 'service'=>null, 'cat'=>'remont-smart-chasov'],
            ['name'=>'Не обновляются', 'slug'=>'ne-obnovlyayutsya', 'service'=>'proshivka-po', 'cat'=>'remont-smart-chasov'],
            ['name'=>'Не работает вибрация', 'slug'=>'ne-rabotaet-vibraciya', 'service'=>'remont-vibromotora', 'cat'=>'remont-smart-chasov'],
            ['name'=>'Слетело крепление ремешка', 'slug'=>'sletelo-kreplenie-remeshka', 'service'=>'zamena-remeshka', 'cat'=>'remont-smart-chasov'],
        ];

        // Обновляем $serviceMap на случай, если otherDevices добавили новые сервисы
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
                'description'   => $d['name'], // description = name (по ТЗ нет отдельного)
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