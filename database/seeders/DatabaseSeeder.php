<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\DeviceModel;
use App\Models\LandingPage;
use App\Models\Lead;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Отключаем логирование запросов для ускорения сидера (их будут тысячи)
        DB::disableQueryLog();

        // ─── 1. Admin ───
        User::updateOrCreate(
            ['email' => 'admin@svoymaster.ru'],
            ['name' => 'Admin', 'password' => bcrypt('password')]
        );

        $this->command->info('Создаем услуги (Services)...');

        // ─── 2. Услуги (Все из раздела "Цены") ───
        $servicesData = [
            [
                'name' => 'Замена стекла', 'slug' => 'zamena-stekla',
                'price_from' => '1500', 'duration_text' => 'от 30 минут', 'warranty_text' => '1 год'
            ],
            [
                'name' => 'Замена экрана (дисплея)', 'slug' => 'zamena-ekrana',
                'price_from' => '2500', 'duration_text' => 'от 40 минут', 'warranty_text' => '1 год'
            ],
            [
                'name' => 'Замена аккумулятора (батареи)', 'slug' => 'zamena-akkumulyatora',
                'price_from' => '1200', 'duration_text' => 'от 15 минут', 'warranty_text' => '6 месяцев'
            ],
            [
                'name' => 'Замена разъема зарядки', 'slug' => 'zamena-razema-zaryadki',
                'price_from' => '1000', 'duration_text' => 'от 30 минут', 'warranty_text' => '3 месяца'
            ],
            [
                'name' => 'Ремонт после залития', 'slug' => 'remont-posle-zalitiya',
                'price_from' => '2000', 'duration_text' => 'от 1 дня', 'warranty_text' => 'без гарантии (индивидуально)'
            ],
        ];

        $serviceObjects = [];
        foreach ($servicesData as $svc) {
            $serviceObjects[] = Service::updateOrCreate(
                ['slug' => $svc['slug']],
                [
                    'name' => $svc['name'],
                    'price_from' => $svc['price_from'],
                    'duration_text' => $svc['duration_text'],
                    'warranty_text' => $svc['warranty_text'],
                    'seo_title' => $svc['name'] . ' {brand} {model} в Екатеринбурге — цены, сроки',
                    'seo_description' => 'Профессиональная ' . mb_strtolower($svc['name']) . ' на {brand} {model}. Гарантия: ' . $svc['warranty_text'] . '.',
                    'seo_h1' => $svc['name'] . ' {brand} {model}',
                    'status' => 'active'
                ]
            );
        }

        $this->command->info('Создаем полный каталог (Категории -> Бренды -> Модели -> Посадочные)...');

        // ─── 3. Глобальная структура БД из ТЗ ───
        $catalogData = [
            'remont-telefonov' => [
                'name' => 'Телефоны',
                'brands' => [
                    'apple' => ['name' => 'iPhone (Apple)', 'models' => [
                        'iphone-6'=>'iPhone 6','iphone-6s'=>'iPhone 6s','iphone-6s-plus'=>'iPhone 6s Plus','iphone-7'=>'iPhone 7','iphone-7-plus'=>'iPhone 7 Plus','iphone-8'=>'iPhone 8','iphone-8-plus'=>'iPhone 8 Plus','iphone-x'=>'iPhone X','iphone-xr'=>'iPhone XR','iphone-xs'=>'iPhone XS','iphone-xs-max'=>'iPhone XS Max','iphone-11'=>'iPhone 11','iphone-11-pro'=>'iPhone 11 Pro','iphone-11-pro-max'=>'iPhone 11 Pro Max','iphone-12'=>'iPhone 12','iphone-12-mini'=>'iPhone 12 Mini','iphone-12-pro'=>'iPhone 12 Pro','iphone-12-pro-max'=>'iPhone 12 Pro Max','iphone-13'=>'iPhone 13','iphone-13-mini'=>'iPhone 13 Mini','iphone-13-pro'=>'iPhone 13 Pro','iphone-13-pro-max'=>'iPhone 13 Pro Max','iphone-14'=>'iPhone 14','iphone-14-plus'=>'iPhone 14 Plus','iphone-14-pro'=>'iPhone 14 Pro','iphone-14-pro-max'=>'iPhone 14 Pro Max','iphone-15'=>'iPhone 15','iphone-15-plus'=>'iPhone 15 Plus','iphone-15-pro'=>'iPhone 15 Pro','iphone-15-pro-max'=>'iPhone 15 Pro Max','iphone-16e'=>'iPhone 16e','iphone-17'=>'iPhone 17','iphone-17-plus'=>'iPhone 17 Plus','iphone-17-air'=>'iPhone 17 Air','iphone-17-pro'=>'iPhone 17 Pro','iphone-17-pro-max'=>'iPhone 17 Pro Max','iphone-17e'=>'iPhone 17e'
                    ]],
                    'samsung' => ['name' => 'Samsung', 'models' => [
                        'a3-2016'=>'Samsung A3 2016','a3-2017'=>'Samsung A3 2017','a5-2016'=>'Samsung A5 2016','a5-2017'=>'Samsung A5 2017','a5-sm-a500'=>'Samsung A5 SM-A500','a7-sm-a700'=>'Samsung A7 SM-A700','a7-sm-a720'=>'Samsung A7 SM-A720','a7-2018-sm-a750'=>'Samsung A7 (2018) SM-A750','a8-2018'=>'Samsung A8 (2018)','j1-sm-j120'=>'Samsung J1 SM-J120','j2-2018-j250'=>'Samsung J2 (2018) J250','j3-2016-sm-j320'=>'Samsung J3 2016 SM-J320','j3-2017-sm-j330'=>'Samsung J3 2017 SM-J330','j4-2018-sm-j400'=>'Samsung J4 (2018) SM-J400','j4-plus-sm-j415'=>'Samsung J4 Plus SM-J415','j5-sm-j500'=>'Samsung J5 SM-J500','j5-sm-j510'=>'Samsung J5 SM-J510','j5-sm-j530'=>'Samsung J5 SM-J530','j6-sm-j600'=>'Samsung J6 SM-J600','j7-sm-j710'=>'Samsung J7 SM-J710','j7-sm-j730'=>'Samsung J7 SM-J730','s3'=>'Samsung S3','s4'=>'Samsung S4','s5'=>'Samsung S5','s6'=>'Samsung S6','s6-edge'=>'Samsung S6 Edge','s6-edge-plus'=>'Samsung S6 Edge Plus','s7'=>'Samsung S7','s7-edge'=>'Samsung S7 Edge','s8'=>'Samsung S8','s8-plus'=>'Samsung S8 Plus','s9'=>'Samsung S9','s10'=>'Samsung S10','s20'=>'Samsung S20','note-10'=>'Samsung Note 10','note-20'=>'Samsung Note 20'
                    ]],
                    'xiaomi' => ['name' => 'Xiaomi', 'models' => [
                        'redmi-4x'=>'Xiaomi Redmi 4X','redmi-note-4x'=>'Xiaomi Redmi Note 4X','redmi-note-4'=>'Xiaomi Redmi Note 4','redmi-5-plus'=>'Xiaomi Redmi 5 Plus','redmi-4a'=>'Xiaomi Redmi 4A','redmi-note-5a'=>'Xiaomi Redmi Note 5A','redmi-note-5'=>'Xiaomi Redmi Note 5','redmi-5'=>'Xiaomi Redmi 5','mi-a1'=>'Xiaomi Mi A1','mi-a2'=>'Xiaomi Mi A2','mi-6'=>'Xiaomi Mi 6','redmi-3s'=>'Xiaomi Redmi 3S','redmi-5a'=>'Xiaomi Redmi 5A','redmi-4-pro-prime'=>'Xiaomi Redmi 4 Pro/Prime','redmi-4'=>'Xiaomi Redmi 4','redmi-note-3'=>'Xiaomi Redmi Note 3','mi-5'=>'Xiaomi Mi 5','redmi-note-6-pro'=>'Xiaomi Redmi Note 6 Pro','redmi-6a'=>'Xiaomi Redmi 6A','mi-8'=>'Xiaomi Mi 8','redmi-note-7'=>'Xiaomi Redmi Note 7','redmi-note-3-pro'=>'Xiaomi Redmi Note 3 Pro','mi-8-se'=>'Xiaomi Mi 8 SE','redmi-3'=>'Xiaomi Redmi 3','mi-8-lite'=>'Xiaomi Mi 8 Lite','mi-max-2'=>'Xiaomi Mi Max 2','mi-5s'=>'Xiaomi Mi 5S','mi-a2-lite'=>'Xiaomi Mi A2 Lite','mi-max'=>'Xiaomi Mi Max','redmi-note-5-pro'=>'Xiaomi Redmi Note 5 Pro','mi-4'=>'Xiaomi Mi 4','redmi-6'=>'Xiaomi Redmi 6','redmi-s2'=>'Xiaomi Redmi S2','mi-mix-2'=>'Xiaomi Mi Mix 2','mi-4c'=>'Xiaomi Mi 4C','mi-5s-plus'=>'Xiaomi Mi 5S Plus','mi-4i'=>'Xiaomi Mi 4i','mi-note'=>'Xiaomi Mi Note','redmi-note-2-prime'=>'Xiaomi Redmi Note 2 Prime','mi-note-2'=>'Xiaomi Mi Note 2'
                    ]],
                    'huawei' => ['name' => 'Huawei', 'models' => [
                        'p10'=>'Huawei P10','nova'=>'Huawei Nova','mate-10'=>'Huawei Mate 10','mate-10-pro'=>'Huawei Mate 10 Pro','mate-20-lite'=>'Huawei Mate 20 Lite','mate-20-pro'=>'Huawei Mate 20 Pro','mate-9'=>'Huawei Mate 9','mate-9-pro'=>'Huawei Mate 9 Pro','nova-2-plus'=>'Huawei Nova 2 Plus','nova-3i'=>'Huawei Nova 3i','p-smart'=>'Huawei P Smart','p10-plus'=>'Huawei P10 Plus','p9-plus'=>'Huawei P9 Plus','y3-ii'=>'Huawei Y3 II','y5-2017'=>'Huawei Y5 2017','y5-2018'=>'Huawei Y5 2018','y7-2017'=>'Huawei Y7 2017','p20-lite'=>'Huawei P20 Lite','p9'=>'Huawei P9','p10-lite'=>'Huawei P10 Lite','y5-ii'=>'Huawei Y5 II','nova-2'=>'Huawei Nova 2','nova-3'=>'Huawei Nova 3','p9-lite'=>'Huawei P9 Lite','p9-lite-2017'=>'Huawei P9 Lite (2017)','p8-lite'=>'Huawei P8 Lite','ascend-mate-2'=>'Huawei Ascend Mate 2','y9-2018'=>'Huawei Y9 (2018)','y3-2017'=>'Huawei Y3 2017','y6-prime-2018-atu-l42'=>'Huawei Y6 Prime (2018) ATU-L42','p20-pro'=>'Huawei P20 Pro','mate-10-lite'=>'Huawei Mate 10 Lite','ascend-p7'=>'Huawei Ascend P7','ascend-mate-7'=>'Huawei Ascend Mate 7'
                    ]],
                    'meizu' => ['name' => 'Meizu', 'models' => [
                        'm3-note'=>'Meizu M3 Note','m5s'=>'Meizu M5S','m5'=>'Meizu M5','m5-note'=>'Meizu M5 Note','m2-note'=>'Meizu M2 Note','mx-4'=>'Meizu MX 4','pro-6'=>'Meizu Pro 6','mx2'=>'Meizu MX2'
                    ]],
                    'zte' => ['name' => 'ZTE', 'models' => [
                        'blade-v8'=>'ZTE Blade V8','blade-v7'=>'ZTE Blade V7','blade-a6'=>'ZTE Blade A6','blade-a610'=>'ZTE Blade A610','blade-x3'=>'ZTE Blade X3'
                    ]],
                    'lenovo' => ['name' => 'Lenovo', 'models' => [
                        'vibe-z2'=>'Lenovo Vibe Z2','p70'=>'Lenovo P70','p780'=>'Lenovo P780','a2010'=>'Lenovo A2010','blade-x3'=>'Lenovo Blade X3'
                    ]],
                    'asus' => ['name' => 'ASUS', 'models' => [
                        'zenfone-max'=>'ASUS Zenfone Max','zenfone-2'=>'ASUS Zenfone 2','zenfone-3'=>'ASUS Zenfone 3','zenfone-2-laser'=>'ASUS Zenfone 2 Laser','zenfone-3-max'=>'ASUS Zenfone 3 Max','zenfone-max-pro-m1'=>'ASUS Zenfone Max Pro M1','zenfone-4-max'=>'ASUS Zenfone 4 Max'
                    ]],
                    'sony' => ['name' => 'Sony', 'models' => [
                        'xperia-z1'=>'Sony Xperia Z1','xperia-z'=>'Sony Xperia Z','xperia-z2'=>'Sony Xperia Z2','xperia-z5'=>'Sony Xperia Z5','xperia-z3-compact'=>'Sony Xperia Z3 Compact'
                    ]],
                    // Бренды без моделей (добавляем как бренды)
                    'realme'=>['name'=>'realme'],'oppo'=>['name'=>'Oppo'],'vivo'=>['name'=>'Vivo'],'oneplus'=>['name'=>'OnePlus'],'google-pixel'=>['name'=>'Google Pixel'],'nokia'=>['name'=>'Nokia'],'motorola'=>['name'=>'Motorola'],'lg'=>['name'=>'LG'],'htc'=>['name'=>'HTC'],'tecno'=>['name'=>'Tecno'],'infinix'=>['name'=>'Infinix'],'poco'=>['name'=>'Poco'],'blackview'=>['name'=>'Blackview'],'ulefone'=>['name'=>'Ulefone'],'doogee'=>['name'=>'Doogee'],'cubot'=>['name'=>'Cubot'],'alcatel'=>['name'=>'Alcatel'],'philips'=>['name'=>'Philips'],'fly'=>['name'=>'Fly'],'dexp'=>['name'=>'DEXP'],'bq'=>['name'=>'BQ'],'texet'=>['name'=>'Texet'],'oukitel'=>['name'=>'Oukitel'],'umidigi'=>['name'=>'Umidigi'],'vertu'=>['name'=>'Vertu'],
                ]
            ],
            'remont-planshetov' => [
                'name' => 'Планшеты',
                'brands' => [
                    'ipad'=>['name'=>'iPad (Apple)'],'samsung'=>['name'=>'Samsung'],'xiaomi'=>['name'=>'Xiaomi'],'huawei'=>['name'=>'Huawei'],'lenovo'=>['name'=>'Lenovo'],'asus'=>['name'=>'ASUS'],'meizu'=>['name'=>'Meizu'],'sony'=>['name'=>'Sony'],'lg'=>['name'=>'LG'],'nokia'=>['name'=>'Nokia'],'honor'=>['name'=>'Honor'],'realme'=>['name'=>'realme'],'oppo'=>['name'=>'Oppo'],'teclast'=>['name'=>'Teclast'],'blackview'=>['name'=>'Blackview'],'digma'=>['name'=>'Digma'],'prestigio'=>['name'=>'Prestigio'],'irbis'=>['name'=>'Irbis'],'dexp'=>['name'=>'DEXP'],'bq'=>['name'=>'BQ'],'texet'=>['name'=>'Texet'],'amazon-kindle'=>['name'=>'Amazon Kindle'],'microsoft-surface'=>['name'=>'Microsoft Surface']
                ]
            ],
            'remont-noutbukov' => [
                'name' => 'Ноутбуки',
                'brands' => [
                    'apple-macbook'=>['name'=>'Apple MacBook'],'asus'=>['name'=>'Asus'],'hp'=>['name'=>'HP'],'lenovo'=>['name'=>'Lenovo'],'acer'=>['name'=>'Acer'],'dell'=>['name'=>'Dell'],'samsung'=>['name'=>'Samsung'],'sony'=>['name'=>'Sony'],'toshiba'=>['name'=>'Toshiba'],'huawei'=>['name'=>'Huawei'],'honor'=>['name'=>'Honor'],'xiaomi'=>['name'=>'Xiaomi'],'msi'=>['name'=>'MSI'],'gigabyte'=>['name'=>'Gigabyte'],'razer'=>['name'=>'Razer'],'irbis'=>['name'=>'Irbis'],'dexp'=>['name'=>'DEXP'],'digma'=>['name'=>'Digma'],'prestigio'=>['name'=>'Prestigio'],'fujitsu'=>['name'=>'Fujitsu'],'packard-bell'=>['name'=>'Packard Bell'],'emachines'=>['name'=>'eMachines']
                ]
            ],
            'remont-smart-chasov' => [
                'name' => 'Смарт-часы',
                'brands' => [
                    'apple-watch'=>['name'=>'Apple Watch'],'samsung-galaxy-watch'=>['name'=>'Samsung Galaxy Watch'],'huawei-watch'=>['name'=>'Huawei Watch'],'xiaomi-mi-band'=>['name'=>'Xiaomi Mi Band'],'amazfit'=>['name'=>'Amazfit'],'garmin'=>['name'=>'Garmin'],'honor-watch'=>['name'=>'Honor Watch'],'realme-watch'=>['name'=>'Realme Watch']
                ]
            ]
        ];

        // "Другие устройства" заводим просто как категории (согласно структуре ЧПУ)
        $otherCategories = [
            'remont-komputerov'=>'Ремонт компьютеров', 'remont-monitorov'=>'Ремонт мониторов', 'remont-monoblokov'=>'Ремонт моноблоков', 'remont-televizorov'=>'Ремонт телевизоров', 'remont-pristavok'=>'Ремонт игровых приставок', 'remont-dzhojstikov'=>'Ремонт джойстиков и геймпадов', 'remont-naushnikov'=>'Ремонт наушников', 'remont-portativnyh-kolonok'=>'Ремонт портативных колонок', 'remont-fotoapparatov'=>'Ремонт фотоаппаратов', 'remont-videokamer'=>'Ремонт видеокамер', 'remont-ekshn-kamer'=>'Ремонт экшн-камер', 'remont-obektivov'=>'Ремонт объективов', 'remont-fotovspyshek'=>'Ремонт фотовспышек', 'remont-stabilizatorov'=>'Ремонт стабилизаторов', 'remont-elektronnyh-knig'=>'Ремонт электронных книг', 'remont-kvadrokopterov'=>'Ремонт квадрокоптеров и дронов', 'remont-robotov-pylesosov'=>'Ремонт роботов-пылесосов', 'remont-kofemashin'=>'Ремонт кофемашин', 'remont-terminalov-sbora-dannyh'=>'Ремонт терминалов сбора данных', 'remont-elektrosamokatov'=>'Ремонт электросамокатов', 'remont-giroskuterov'=>'Ремонт гироскутеров', 'remont-monokoles'=>'Ремонт моноколес'
        ];

        // ─── 4. Запускаем циклы генерации ───
        
        // Транзакция, чтобы SQLite/MySQL отработали это за долю секунды
        DB::beginTransaction();

        try {
            foreach ($catalogData as $catSlug => $catData) {
                $category = Category::updateOrCreate(
                    ['slug' => $catSlug],
                    [
                        'name' => $catData['name'],
                        'seo_title' => "{$catData['name']} в Екатеринбурге — ремонт и сервис",
                        'seo_h1' => $catData['name'],
                        'status' => 'active',
                    ]
                );

                foreach ($catData['brands'] as $brandSlug => $brandData) {
                    $brand = Brand::updateOrCreate(
                        ['slug' => $brandSlug],
                        [
                            'name' => $brandData['name'],
                            'seo_title' => "Ремонт {$brandData['name']} в Екатеринбурге",
                            'seo_h1' => "Ремонт {$brandData['name']}",
                            'status' => 'active',
                        ]
                    );

                    // Если у бренда есть модели
                    if (isset($brandData['models'])) {
                        foreach ($brandData['models'] as $modelSlug => $modelName) {
                            $model = DeviceModel::updateOrCreate(
                                [
                                    'slug' => $modelSlug,
                                    'brand_id' => $brand->id,
                                    'category_id' => $category->id,
                                ],
                                [
                                    'name' => $modelName,
                                    'seo_title' => "Ремонт {$modelName} в Екатеринбурге",
                                    'seo_h1' => "Ремонт {$modelName}",
                                    'status' => 'active',
                                ]
                            );

                            // Создаем LandingPages для каждой из 5 услуг для этой модели!
                            foreach ($serviceObjects as $svcObj) {
                                LandingPage::updateOrCreate(
                                    [
                                        'model_id' => $model->id,
                                        'service_id' => $svcObj->id,
                                    ],
                                    [
                                        'category_id' => $category->id,
                                        'brand_id' => $brand->id,
                                        // Избегаем коллизий для одинаковых slug моделей у разных брендов/категорий
                                        'slug' => Str::limit(
                                            $svcObj->slug . '-' . $category->slug . '-' . $brand->slug . '-' . $model->slug,
                                            255,
                                            ''
                                        ),
                                        'status' => 'active',
                                    ]
                                );
                            }
                        }
                    }
                }
            }

            // Добавляем другие категории без брендов/моделей
            foreach ($otherCategories as $slug => $name) {
                Category::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'name' => $name,
                        'seo_title' => "{$name} в Екатеринбурге — цены, сроки, гарантия",
                        'seo_h1' => $name,
                        'status' => 'active',
                    ]
                );
            }

            DB::commit();
            $this->command->info('Все модели и посадочные страницы успешно сгенерированы!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Ошибка при генерации каталога: ' . $e->getMessage());
        }

        // ─── 5. Тестовые Лиды ───
        Lead::updateOrCreate(
            ['phone' => '+7 (912) 345-67-89'],
            [
                'name' => 'Иван Петров',
                'comment' => 'Разбил стекло на iPhone 17, сколько будет стоить?',
                'page_url' => '/remont-telefonov/apple/iphone-17/zamena-stekla',
                'utm_source' => 'yandex',
                'status' => 'new',
            ]
        );

        // ─── 6. Отзывы ───
        Review::updateOrCreate(
            ['client_name' => 'Александр Кузнецов', 'device_name' => 'Ремонт iPhone 13'],
            [
                'text' => 'Обратился с разбитым экраном iPhone 13. Все сделали за 40 минут, дисплей как новый, Face ID работает. Очень доволен сервисом и отношением мастера.',
                'rating' => 5,
                'is_published' => true,
                'published_at' => now()->subDays(10)->toDateString(),
            ]
        );

        Review::updateOrCreate(
            ['client_name' => 'Марина Орлова', 'device_name' => 'Замена батареи Samsung Galaxy S23'],
            [
                'text' => 'Телефон стал быстро разряжаться, в сервисе сразу провели диагностику и предложили замену аккумулятора. Сделали в тот же день, теперь держит заряд отлично.',
                'rating' => 5,
                'is_published' => true,
                'published_at' => now()->subDays(6)->toDateString(),
            ]
        );

        Review::updateOrCreate(
            ['client_name' => 'Дмитрий Соколов', 'device_name' => 'Ремонт MacBook Air M2'],
            [
                'text' => 'После попадания жидкости MacBook не включался. В другом сервисе сказали, что только замена платы, а здесь смогли восстановить и сохранить данные. Спасибо за профессионализм.',
                'rating' => 5,
                'is_published' => true,
                'published_at' => now()->subDays(3)->toDateString(),
            ]
        );
    }
}