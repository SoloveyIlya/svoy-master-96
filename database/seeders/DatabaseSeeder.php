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
        // Отключаем логирование запросов для ускорения сидера (их будут тысячи)
        DB::disableQueryLog();

        // ─── 1. Admin ───
        User::updateOrCreate(
            ['email' => 'admin@svoymaster.ru'],
            ['name' => 'Admin', 'password' => bcrypt('password')]
        );

        $this->command->info('Создаем услуги (Services)...');

        // ─── 2. Услуги (актуальный ликвидный список) ───
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
            [
                'name' => 'Замена задней крышки', 'slug' => 'zamena-zadney-kryshki',
                'price_from' => '1400', 'duration_text' => 'от 40 минут', 'warranty_text' => '6 месяцев'
            ],
            [
                'name' => 'Замена микрофона (собеседник не слышит)', 'slug' => 'zamena-mikrofona',
                'price_from' => '1300', 'duration_text' => 'от 40 минут', 'warranty_text' => '6 месяцев'
            ],
            [
                'name' => 'Замена динамика', 'slug' => 'zamena-dinamika',
                'price_from' => '1300', 'duration_text' => 'от 30 минут', 'warranty_text' => '6 месяцев'
            ],
            [
                'name' => 'Смена ПО, прошивка', 'slug' => 'smena-po-proshivka',
                'price_from' => '1000', 'duration_text' => 'от 1 часа', 'warranty_text' => '30 дней'
            ],
            [
                'name' => 'Разблокировка', 'slug' => 'razblokirovka',
                'price_from' => '1200', 'duration_text' => 'от 1 часа', 'warranty_text' => '30 дней'
            ],
            [
                'name' => 'Замена камеры', 'slug' => 'zamena-kamery',
                'price_from' => '1700', 'duration_text' => 'от 45 минут', 'warranty_text' => '6 месяцев'
            ],
            [
                'name' => 'Замена стекла камеры', 'slug' => 'zamena-stekla-kamery',
                'price_from' => '1100', 'duration_text' => 'от 30 минут', 'warranty_text' => '6 месяцев'
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

        // ─── 2.1. Поломки (Defects) ───
        $this->command->info('Создаем поломки (Defects)...');

        $defectsData = [
            [
                'name' => 'Разбилось стекло',
                'description' => 'Трещины / паутинка',
                'slug' => 'razbilos-steklo',
                'service_slug' => 'zamena-stekla',
            ],
            [
                'name' => 'Не заряжается',
                'description' => 'Разъем / кабель / плата',
                'slug' => 'ne-zaryazhaetsya',
                'service_slug' => 'zamena-razema-zaryadki',
            ],
            [
                'name' => 'Быстро садится',
                'description' => 'Аккумулятор',
                'slug' => 'bystro-saditsya',
                'service_slug' => 'zamena-akkumulyatora',
            ],
            [
                'name' => 'Попала вода',
                'description' => 'Срочно в диагностику',
                'slug' => 'popala-voda',
                'service_slug' => 'remont-posle-zalitiya',
            ],
            [
                'name' => 'Нет сети / Wi-Fi',
                'description' => 'Связь / модуль',
                'slug' => 'net-seti-wifi',
                'service_slug' => 'smena-po-proshivka',
            ],
            [
                'name' => 'Камера / звук',
                'description' => 'Микрофон / динамик',
                'slug' => 'kamera-zvuk',
                'service_slug' => 'zamena-mikrofona',
            ],
            [
                'name' => 'Не включается',
                'description' => 'Питание / плата',
                'slug' => 'ne-vklyuchaetsya',
                'service_slug' => 'remont-posle-zalitiya',
            ],
            [
                'name' => 'Тормозит',
                'description' => 'ПО / память',
                'slug' => 'tormozit',
                'service_slug' => 'smena-po-proshivka',
            ],
        ];

        foreach ($defectsData as $defect) {
            $service = Service::where('slug', $defect['service_slug'])->first();

            Defect::updateOrCreate(
                ['slug' => $defect['slug']],
                [
                    'name' => $defect['name'],
                    'description' => $defect['description'],
                    'service_id' => $service?->id,
                    'is_active' => true,
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
                        'iphone-11' => 'iPhone 11',
                        'iphone-11-pro' => 'iPhone 11 Pro',
                        'iphone-11-pro-max' => 'iPhone 11 Pro Max',
                        'iphone-12' => 'iPhone 12',
                        'iphone-12-pro' => 'iPhone 12 Pro',
                        'iphone-12-pro-max' => 'iPhone 12 Pro Max',
                        'iphone-13' => 'iPhone 13',
                        'iphone-13-pro' => 'iPhone 13 Pro',
                        'iphone-13-pro-max' => 'iPhone 13 Pro Max',
                        'iphone-14' => 'iPhone 14',
                        'iphone-14-pro' => 'iPhone 14 Pro',
                        'iphone-14-pro-max' => 'iPhone 14 Pro Max',
                        'iphone-15' => 'iPhone 15',
                        'iphone-15-pro' => 'iPhone 15 Pro',
                        'iphone-15-pro-max' => 'iPhone 15 Pro Max',
                        'iphone-16' => 'iPhone 16',
                        'iphone-16-pro' => 'iPhone 16 Pro',
                        'iphone-16-pro-max' => 'iPhone 16 Pro Max',
                        'iphone-17' => 'iPhone 17',
                        'iphone-17-pro' => 'iPhone 17 Pro',
                        'iphone-17-pro-max' => 'iPhone 17 Pro Max',
                        'iphone-air' => 'iPhone Air',
                    ]],
                    'samsung' => ['name' => 'Samsung', 'models' => [
                        'galaxy-s22' => 'Galaxy S22',
                        'galaxy-s22-plus' => 'Galaxy S22+',
                        'galaxy-s22-ultra' => 'Galaxy S22 Ultra',
                        'galaxy-s23' => 'Galaxy S23',
                        'galaxy-s23-plus' => 'Galaxy S23+',
                        'galaxy-s23-ultra' => 'Galaxy S23 Ultra',
                        'galaxy-s24' => 'Galaxy S24',
                        'galaxy-s24-plus' => 'Galaxy S24+',
                        'galaxy-s24-ultra' => 'Galaxy S24 Ultra',
                        'galaxy-z-fold-4' => 'Galaxy Z Fold 4',
                        'galaxy-z-fold-5' => 'Galaxy Z Fold 5',
                        'galaxy-z-flip-4' => 'Galaxy Z Flip 4',
                        'galaxy-z-flip-5' => 'Galaxy Z Flip 5',
                        'galaxy-a53' => 'Galaxy A53',
                        'galaxy-a54' => 'Galaxy A54',
                        'galaxy-a55' => 'Galaxy A55',
                        'galaxy-s25' => 'Galaxy S25',
                        'galaxy-s25-plus' => 'Galaxy S25+',
                        'galaxy-s25-ultra' => 'Galaxy S25 Ultra',
                        'galaxy-s25-edge' => 'Galaxy S25 Edge',
                        'galaxy-s25-fe' => 'Galaxy S25 FE',
                        'galaxy-s26' => 'Galaxy S26',
                        'galaxy-s26-plus' => 'Galaxy S26+',
                        'galaxy-s26-ultra' => 'Galaxy S26 Ultra',
                    ]],
                    'xiaomi-poco' => ['name' => 'Xiaomi/POCO', 'models' => [
                        'xiaomi-13' => 'Xiaomi 13',
                        'xiaomi-13-pro' => 'Xiaomi 13 Pro',
                        'xiaomi-14' => 'Xiaomi 14',
                        'xiaomi-14-ultra' => 'Xiaomi 14 Ultra',
                        'xiaomi-15' => 'Xiaomi 15',
                        'xiaomi-15-pro' => 'Xiaomi 15 Pro',
                        'xiaomi-15-ultra' => 'Xiaomi 15 Ultra',
                        'redmi-note-12' => 'Redmi Note 12',
                        'redmi-note-12-pro' => 'Redmi Note 12 Pro',
                        'redmi-note-13' => 'Redmi Note 13',
                        'redmi-note-13-pro-plus' => 'Redmi Note 13 Pro+',
                        'poco-x5-pro' => 'POCO X5 Pro',
                        'poco-x6-pro' => 'POCO X6 Pro',
                        'poco-f5' => 'POCO F5',
                    ]],
                    'huawei-honor' => ['name' => 'Huawei/Honor', 'models' => [
                        'huawei-p50-pro' => 'Huawei P50 Pro',
                        'huawei-p60-pro' => 'Huawei P60 Pro',
                        'huawei-mate-50-pro' => 'Huawei Mate 50 Pro',
                        'honor-70' => 'Honor 70',
                        'honor-90' => 'Honor 90',
                        'honor-magic-5-pro' => 'Honor Magic 5 Pro',
                        'honor-magic-6-pro' => 'Honor Magic 6 Pro',
                    ]],
                ]
            ],
            'remont-planshetov' => [
                'name' => 'Планшеты',
                'brands' => [
                    'ipad' => ['name' => 'iPad (Apple)', 'models' => [
                        'ipad-9-10-2' => 'iPad 9 (10.2)',
                        'ipad-10-10-9' => 'iPad 10 (10.9)',
                        'ipad-air-4' => 'iPad Air 4',
                        'ipad-air-5' => 'iPad Air 5',
                        'ipad-mini-6' => 'iPad mini 6',
                        'ipad-pro-11-m1-m2' => 'iPad Pro 11 (M1/M2)',
                        'ipad-pro-12-9-m1-m2' => 'iPad Pro 12.9 (M1/M2)',
                    ]],
                    'samsung' => ['name' => 'Samsung', 'models' => [
                        'galaxy-tab-s8' => 'Galaxy Tab S8',
                        'galaxy-tab-s8-ultra' => 'Galaxy Tab S8 Ultra',
                        'galaxy-tab-s9' => 'Galaxy Tab S9',
                        'galaxy-tab-s9-ultra' => 'Galaxy Tab S9 Ultra',
                        'galaxy-tab-a8' => 'Galaxy Tab A8',
                        'galaxy-tab-a9' => 'Galaxy Tab A9',
                    ]],
                    'xiaomi' => ['name' => 'Xiaomi', 'models' => [
                        'xiaomi-pad-5' => 'Xiaomi Pad 5',
                        'xiaomi-pad-6' => 'Xiaomi Pad 6',
                    ]],
                ]
            ],
            'remont-noutbukov' => [
                'name' => 'Ноутбуки',
                'brands' => [
                    'apple-macbook' => ['name' => 'Apple MacBook', 'models' => [
                        'macbook-air-m1-2020' => 'MacBook Air M1 (2020)',
                        'macbook-air-m2-2022' => 'MacBook Air M2 (2022)',
                        'macbook-air-m3-2024' => 'MacBook Air M3 (2024)',
                        'macbook-air-m4' => 'MacBook Air M4',
                        'macbook-pro-m4' => 'MacBook Pro M4',
                        'macbook-air-m5' => 'MacBook Air M5',
                        'macbook-pro-m5' => 'MacBook Pro M5',
                        'macbook-pro-14-m1-m2-m3' => 'MacBook Pro 14 (M1/M2/M3)',
                        'macbook-pro-16-m1-m2-m3' => 'MacBook Pro 16 (M1/M2/M3)',
                    ]],
                    'asus' => ['name' => 'Asus', 'models' => [
                        'zenbook-14' => 'ZenBook 14',
                        'rog-strix' => 'ROG Strix',
                        'tuf-gaming' => 'TUF Gaming',
                        'vivobook' => 'VivoBook',
                    ]],
                    'lenovo' => ['name' => 'Lenovo', 'models' => [
                        'ideapad-5' => 'IdeaPad 5',
                        'legion-5' => 'Legion 5',
                        'thinkpad' => 'ThinkPad',
                        'yoga' => 'Yoga',
                    ]],
                ]
            ],
            'remont-smart-chasov' => [
                'name' => 'Смарт-часы',
                'brands' => [
                    'apple-watch' => ['name' => 'Apple Watch', 'models' => [
                        'apple-watch-series-7' => 'Apple Watch Series 7',
                        'apple-watch-series-8' => 'Apple Watch Series 8',
                        'apple-watch-series-9' => 'Apple Watch Series 9',
                        'apple-watch-se-2' => 'Apple Watch SE 2',
                        'apple-watch-ultra' => 'Apple Watch Ultra',
                        'apple-watch-ultra-2' => 'Apple Watch Ultra 2',
                    ]],
                    'samsung-galaxy-watch' => ['name' => 'Samsung Galaxy Watch', 'models' => [
                        'galaxy-watch-4' => 'Galaxy Watch 4',
                        'galaxy-watch-5' => 'Galaxy Watch 5',
                        'galaxy-watch-6' => 'Galaxy Watch 6',
                        'galaxy-watch-6-classic' => 'Galaxy Watch 6 Classic',
                    ]],
                ]
            ]
        ];

        // "Другие устройства" заводим просто как категории (согласно структуре ЧПУ)
        $otherCategories = [
            'remont-komputerov' => 'Ремонт компьютеров',
            'remont-monitorov' => 'Ремонт мониторов',
            'remont-monoblokov' => 'Ремонт моноблоков',
            'remont-televizorov' => 'Ремонт телевизоров',
            'remont-pristavok' => 'Ремонт игровых приставок',
            'remont-dzhojstikov' => 'Ремонт джойстиков и геймпадов',
            'remont-naushnikov' => 'Ремонт наушников',
            'remont-portativnyh-kolonok' => 'Ремонт портативных колонок',
            'remont-fotoapparatov' => 'Ремонт фотоаппаратов',
            'remont-obektivov' => 'Ремонт объективов',
            'remont-fotovspyshek' => 'Ремонт фотовспышек',
            'remont-elektronnyh-knig' => 'Ремонт электронных книг',
            'remont-kvadrokopterov' => 'Ремонт квадрокоптеров и дронов',
            'remont-robotov-pylesosov' => 'Ремонт роботов-пылесосов',
            'remont-terminalov-sbora-dannyh' => 'Ремонт терминалов сбора данных',
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

                            // Создаем LandingPages для каждой услуги для этой модели
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

        // ─── 4.5. Генерация SEO-срезов (ServiceScopes) ───
        $this->command->info('Создаем логические срезы (ServiceScopes) для брендов и услуг...');

        $brandsWithModels = Brand::has('models')->get();
        $allServices = Service::all();

        foreach ($brandsWithModels as $b) {
            foreach ($allServices as $s) {
                ServiceScope::updateOrCreate(
                    [
                        'scope_type' => 'brand',
                        'scope_id'   => $b->id,
                        'service_id' => $s->id,
                    ],
                    [
                        'seo_title' => "{$s->name} на {$b->name} в Екатеринбурге — цены, адреса",
                        'seo_h1'    => "{$s->name} {$b->name}",
                    ]
                );
            }
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

        // ─── 7. Примеры работ (DeviceCases) ───
        $this->command->info('Создаем примеры работ (Cases)...');

        \App\Models\DeviceCase::updateOrCreate(
            ['title' => 'Замена стекла iPhone 13 Pro'],
            [
                'description' => 'Упал на асфальт, экран работал исправно, но стекло было в паутине. Поменяли стекло с сохранением оригинальной матрицы.',
                'image_before' => 'https://placehold.co/600x400/EEE/31343C?text=iPhone+До',
                'image_after' => 'https://placehold.co/600x400/EEE/31343C?text=iPhone+После',
                'price' => 7500,
                'duration' => '1.5 часа',
                'is_published' => true,
            ]
        );

        \App\Models\DeviceCase::updateOrCreate(
            ['title' => 'Замена аккумулятора Samsung S22 Ultra'],
            [
                'description' => 'Телефон быстро садился и выключался на холоде. Установили оригинальный аккумулятор, восстановили влагозащиту.',
                'image_before' => 'https://placehold.co/600x400/EEE/31343C?text=Samsung+До',
                'image_after' => 'https://placehold.co/600x400/EEE/31343C?text=Samsung+После',
                'price' => 4200,
                'duration' => '40 минут',
                'is_published' => true,
            ]
        );

        \App\Models\DeviceCase::updateOrCreate(
            ['title' => 'Восстановление MacBook Pro M1 после залития'],
            [
                'description' => 'Пролили кофе на клавиатуру. Ноутбук перестал включаться. Произвели чистку в ультразвуковой ванне и пайку цепей питания.',
                'image_before' => 'https://placehold.co/600x400/EEE/31343C?text=MacBook+До',
                'image_after' => 'https://placehold.co/600x400/EEE/31343C?text=MacBook+После',
                'price' => 15000,
                'duration' => '2 дня',
                'is_published' => true,
            ]
        );
    }
}