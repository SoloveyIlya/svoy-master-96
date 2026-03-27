<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $categories = DB::table('categories')->get()->keyBy('slug');
        $services   = DB::table('services')->get()->keyBy('slug');
        $now        = now();

        $newDefects = [

            // ── ТЕЛЕФОНЫ: 2 пропущенные услуги ─────────────────────────────────
            ['name' => 'Поцарапано стекло камеры',    'slug' => 'telefon-царапина-стекло-камеры',  'service' => 'zamena-stekla-kamery', 'cat' => 'remont-telefonov'],
            ['name' => 'Забыт пароль / блокировка',   'slug' => 'telefon-zabyt-parol',             'service' => 'razblokirovka',        'cat' => 'remont-telefonov'],

            // ── ПЛАНШЕТЫ: 2 пропущенные услуги ─────────────────────────────────
            ['name' => 'Поцарапано стекло камеры',    'slug' => 'planshet-carap-steklo-kamery',    'service' => 'zamena-stekla-kamery', 'cat' => 'remont-planshetov'],
            ['name' => 'Забыт пароль / блокировка',   'slug' => 'planshet-zabyt-parol',            'service' => 'razblokirovka',        'cat' => 'remont-planshetov'],

            // ── СМАРТ-ЧАСЫ: 2 пропущенные услуги ───────────────────────────────
            ['name' => 'Разбита задняя крышка',        'slug' => 'chasy-razbita-kryshka',           'service' => 'zamena-zadnej-kryshki', 'cat' => 'remont-smart-chasov'],
            ['name' => 'Забыт пароль / блокировка',    'slug' => 'chasy-zabyt-parol',               'service' => 'razblokirovka',         'cat' => 'remont-smart-chasov'],

            // ── КОМПЬЮТЕРЫ (remont-komputerov) ─────────────────────────────────
            ['name' => 'Сильно греется',               'slug' => 'pc-silno-greetsya',               'service' => 'chistka-ot-pyli',           'cat' => 'remont-komputerov'],
            ['name' => 'Не видит жесткий диск',        'slug' => 'pc-ne-vidit-disk',                'service' => 'zamena-hdd-ssd',            'cat' => 'remont-komputerov'],
            ['name' => 'Не включается',                'slug' => 'pc-ne-vklyuchaetsya',             'service' => 'zamena-bloka-pitaniya',     'cat' => 'remont-komputerov'],
            ['name' => 'Зависает / тормозит',          'slug' => 'pc-zavisaet',                     'service' => 'ustanovka-windows',         'cat' => 'remont-komputerov'],
            ['name' => 'Синий экран смерти (BSOD)',    'slug' => 'pc-bsod',                         'service' => 'ustanovka-windows',         'cat' => 'remont-komputerov'],
            ['name' => 'Не работает оперативная память','slug' => 'pc-ne-rabotaet-ram',             'service' => 'zamena-operativnoj-pamyati','cat' => 'remont-komputerov'],
            ['name' => 'Нет изображения',              'slug' => 'pc-net-izobrazheniya',            'service' => 'zamena-videokarty',         'cat' => 'remont-komputerov'],
            ['name' => 'Не работает материнская плата','slug' => 'pc-ne-rabotaet-mb',               'service' => 'zamena-materinskoj-platy',  'cat' => 'remont-komputerov'],
            ['name' => 'Потеря данных',                'slug' => 'pc-poterya-dannyh',               'service' => 'vosstanovlenie-dannyh',     'cat' => 'remont-komputerov'],
            ['name' => 'Шумит вентилятор',             'slug' => 'pc-shumit-ventilator',            'service' => 'zamena-termopasty',         'cat' => 'remont-komputerov'],

            // ── МОНИТОРЫ (remont-monitorov) ─────────────────────────────────────
            ['name' => 'Разбит экран',                 'slug' => 'monitor-razbit-ekran',            'service' => 'zamena-matricy',        'cat' => 'remont-monitorov'],
            ['name' => 'Не включается',                'slug' => 'monitor-ne-vklyuchaetsya',        'service' => 'zamena-bloka-pitaniya', 'cat' => 'remont-monitorov'],
            ['name' => 'Нет подсветки / темный экран', 'slug' => 'monitor-net-podsvetki',           'service' => 'remont-podsvetki',      'cat' => 'remont-monitorov'],
            ['name' => 'Полосы на экране',             'slug' => 'monitor-polosy-na-ekrane',        'service' => 'zamena-shlejfa',        'cat' => 'remont-monitorov'],
            ['name' => 'Мигает изображение',           'slug' => 'monitor-migaet-izobrazhenie',     'service' => 'zamena-shlejfa',        'cat' => 'remont-monitorov'],
            ['name' => 'Нет изображения',              'slug' => 'monitor-net-izobrazheniya',       'service' => 'remont-materinskoj-platy', 'cat' => 'remont-monitorov'],

            // ── МОНОБЛОКИ (remont-monoblokov) ───────────────────────────────────
            ['name' => 'Разбит экран',                 'slug' => 'monoblok-razbit-ekran',           'service' => 'zamena-matricy',            'cat' => 'remont-monoblokov'],
            ['name' => 'Сильно греется',               'slug' => 'monoblok-silno-greetsya',         'service' => 'chistka-ot-pyli',           'cat' => 'remont-monoblokov'],
            ['name' => 'Не видит жесткий диск',        'slug' => 'monoblok-ne-vidit-disk',          'service' => 'zamena-hdd-ssd',            'cat' => 'remont-monoblokov'],
            ['name' => 'Не включается',                'slug' => 'monoblok-ne-vklyuchaetsya',       'service' => 'zamena-bloka-pitaniya',     'cat' => 'remont-monoblokov'],
            ['name' => 'Зависает',                     'slug' => 'monoblok-zavisaet',               'service' => 'zamena-operativnoj-pamyati','cat' => 'remont-monoblokov'],
            ['name' => 'Шумит вентилятор',             'slug' => 'monoblok-shumit-ventilator',      'service' => 'chistka-ot-pyli',           'cat' => 'remont-monoblokov'],

            // ── ТЕЛЕВИЗОРЫ (remont-televizorov) ─────────────────────────────────
            ['name' => 'Разбит экран',                 'slug' => 'tv-razbit-ekran',                 'service' => 'zamena-matricy',           'cat' => 'remont-televizorov'],
            ['name' => 'Не включается',                'slug' => 'tv-ne-vklyuchaetsya',             'service' => 'remont-bloka-pitaniya',    'cat' => 'remont-televizorov'],
            ['name' => 'Нет подсветки / темный экран', 'slug' => 'tv-net-podsvetki',                'service' => 'remont-podsvetki',         'cat' => 'remont-televizorov'],
            ['name' => 'Полосы на экране',             'slug' => 'tv-polosy-na-ekrane',             'service' => 'zamena-shlejfa',           'cat' => 'remont-televizorov'],
            ['name' => 'Зависает Smart TV',            'slug' => 'tv-zavisaet',                     'service' => 'obnovlenie-proshivki',     'cat' => 'remont-televizorov'],
            ['name' => 'Нет изображения',              'slug' => 'tv-net-izobrazheniya',            'service' => 'remont-materinskoj-platy', 'cat' => 'remont-televizorov'],
            ['name' => 'Нет звука',                    'slug' => 'tv-net-zvuka',                    'service' => 'remont-materinskoj-platy', 'cat' => 'remont-televizorov'],

            // ── ПРИСТАВКИ (remont-pristavok) ─────────────────────────────────────
            ['name' => 'Сильно греется',               'slug' => 'pristavka-silno-greetsya',        'service' => 'zamena-kulera',         'cat' => 'remont-pristavok'],
            ['name' => 'Не включается',                'slug' => 'pristavka-ne-vklyuchaetsya',      'service' => 'remont-bloka-pitaniya', 'cat' => 'remont-pristavok'],
            ['name' => 'Не читает диски',              'slug' => 'pristavka-ne-chitaet-diski',      'service' => 'remont-privoda',        'cat' => 'remont-pristavok'],
            ['name' => 'Зависает / перезагружается',   'slug' => 'pristavka-zavisaet',              'service' => 'zamena-termopasty',     'cat' => 'remont-pristavok'],
            ['name' => 'Красный / желтый индикатор',   'slug' => 'pristavka-krasnyj-indikator',     'service' => 'remont-bloka-pitaniya', 'cat' => 'remont-pristavok'],
            ['name' => 'Тормозит / лагает',            'slug' => 'pristavka-tormozit',              'service' => 'pereproshivka',         'cat' => 'remont-pristavok'],

            // ── ДЖОЙСТИКИ (remont-dzhojstikov) ──────────────────────────────────
            ['name' => 'Быстро разряжается',           'slug' => 'dzhojstik-bystro-razryazhaetsya', 'service' => 'zamena-akkumulyatora',  'cat' => 'remont-dzhojstikov'],
            ['name' => 'Не заряжается',                'slug' => 'dzhojstik-ne-zaryazhaetsya',      'service' => 'zamena-razema-zaryadki','cat' => 'remont-dzhojstikov'],
            ['name' => 'Не работает вибрация',         'slug' => 'dzhojstik-ne-rabotaet-vibraciya', 'service' => 'remont-vibromotora',    'cat' => 'remont-dzhojstikov'],
            ['name' => 'Дрейф аналогового стика',      'slug' => 'dzhojstik-drejf-stika',           'service' => 'remont-drifta',         'cat' => 'remont-dzhojstikov'],
            ['name' => 'Не нажимаются кнопки',         'slug' => 'dzhojstik-ne-nazhimayutsya-knopki','service' => 'remont-stika',         'cat' => 'remont-dzhojstikov'],
            ['name' => 'Залипает стик',                'slug' => 'dzhojstik-zalipaet-stik',         'service' => 'remont-stika',          'cat' => 'remont-dzhojstikov'],

            // ── НАУШНИКИ (remont-naushnikov) ─────────────────────────────────────
            ['name' => 'Быстро разряжается',           'slug' => 'naushniki-bystro-razryazhaetsya', 'service' => 'zamena-akkumulyatora', 'cat' => 'remont-naushnikov'],
            ['name' => 'Нет звука в одном ухе',        'slug' => 'naushniki-net-zvuka',             'service' => 'zamena-dinamika',     'cat' => 'remont-naushnikov'],
            ['name' => 'Тихий звук',                   'slug' => 'naushniki-tihij-zvuk',            'service' => 'zamena-dinamika',     'cat' => 'remont-naushnikov'],
            ['name' => 'Не заряжается',                'slug' => 'naushniki-ne-zaryazhaetsya',      'service' => 'zamena-razema',       'cat' => 'remont-naushnikov'],
            ['name' => 'Треск / помехи',               'slug' => 'naushniki-tresk',                 'service' => 'remont-platy',        'cat' => 'remont-naushnikov'],
            ['name' => 'Порвались амбушюры',           'slug' => 'naushniki-porvalis-ambushyury',   'service' => 'zamena-ambushyur',    'cat' => 'remont-naushnikov'],

            // ── ПОРТАТИВНЫЕ КОЛОНКИ (remont-portativnyh-kolonok) ─────────────────
            ['name' => 'Быстро разряжается',           'slug' => 'kolonka-bystro-razryazhaetsya',   'service' => 'zamena-akkumulyatora',   'cat' => 'remont-portativnyh-kolonok'],
            ['name' => 'Не заряжается',                'slug' => 'kolonka-ne-zaryazhaetsya',        'service' => 'zamena-razema-zaryadki', 'cat' => 'remont-portativnyh-kolonok'],
            ['name' => 'Попала вода / намокла',        'slug' => 'kolonka-popala-voda',             'service' => 'remont-posle-zalitiya',  'cat' => 'remont-portativnyh-kolonok'],
            ['name' => 'Хрипит / тихий звук',          'slug' => 'kolonka-hripit',                  'service' => 'zamena-dinamika',        'cat' => 'remont-portativnyh-kolonok'],
            ['name' => 'Не включается',                'slug' => 'kolonka-ne-vklyuchaetsya',        'service' => 'remont-platy',           'cat' => 'remont-portativnyh-kolonok'],
            ['name' => 'Треск при воспроизведении',    'slug' => 'kolonka-tresk',                   'service' => 'zamena-dinamika',        'cat' => 'remont-portativnyh-kolonok'],

            // ── ФОТОАППАРАТЫ (remont-fotoapparatov) ─────────────────────────────
            ['name' => 'Разбит экран',                 'slug' => 'foto-razbit-ekran',               'service' => 'zamena-ekrana',     'cat' => 'remont-fotoapparatov'],
            ['name' => 'Быстро разряжается',           'slug' => 'foto-bystro-razryazhaetsya',      'service' => 'zamena-akkumulyatora', 'cat' => 'remont-fotoapparatov'],
            ['name' => 'Мутные / размытые фото',       'slug' => 'foto-mutnye-foto',                'service' => 'chistka-matricy',   'cat' => 'remont-fotoapparatov'],
            ['name' => 'Не срабатывает затвор',        'slug' => 'foto-ne-srabatyvaet-zatvor',      'service' => 'zamena-zatvora',    'cat' => 'remont-fotoapparatov'],
            ['name' => 'Не фокусируется',              'slug' => 'foto-ne-fokusiruetsya',           'service' => 'remont-obektiva',   'cat' => 'remont-fotoapparatov'],
            ['name' => 'Пятна и шум на фото',          'slug' => 'foto-pyatna-na-foto',             'service' => 'chistka-matricy',   'cat' => 'remont-fotoapparatov'],

            // ── ОБЪЕКТИВЫ (remont-obektivov) ────────────────────────────────────
            ['name' => 'Не фокусируется',              'slug' => 'ob-ne-fokusiruetsya',             'service' => 'zamena-shesterenok',   'cat' => 'remont-obektivov'],
            ['name' => 'Грибок и пыль внутри',         'slug' => 'ob-gribok-i-pyl',                 'service' => 'chistka-obektiva',     'cat' => 'remont-obektivov'],
            ['name' => 'Не работает стабилизатор',     'slug' => 'ob-ne-rabotaet-stabilizator',     'service' => 'remont-stabilizatora', 'cat' => 'remont-obektivov'],
            ['name' => 'Не работает диафрагма',        'slug' => 'ob-ne-rabotaet-diafragma',        'service' => 'zamena-diafragmy',     'cat' => 'remont-obektivov'],
            ['name' => 'Сломан байонет',               'slug' => 'ob-sloman-bajonet',               'service' => 'remont-bajoneta',      'cat' => 'remont-obektivov'],
            ['name' => 'Заедает зум',                  'slug' => 'ob-zaedaet-zum',                  'service' => 'zamena-shesterenok',   'cat' => 'remont-obektivov'],

            // ── ФОТОВСПЫШКИ (remont-fotovspyshek) ───────────────────────────────
            ['name' => 'Не заряжается',                'slug' => 'vspyshka-ne-zaryazhaetsya',       'service' => 'zamena-akkumulyatora',  'cat' => 'remont-fotovspyshek'],
            ['name' => 'Не срабатывает вспышка',       'slug' => 'vspyshka-ne-srabatyvaet',         'service' => 'zamena-lampy',          'cat' => 'remont-fotovspyshek'],
            ['name' => 'Долго заряжается',             'slug' => 'vspyshka-dolgo-zaryazhaetsya',    'service' => 'remont-kondensatora',   'cat' => 'remont-fotovspyshek'],
            ['name' => 'Не включается',                'slug' => 'vspyshka-ne-vklyuchaetsya',       'service' => 'remont-kondensatora',   'cat' => 'remont-fotovspyshek'],

            // ── ЭЛЕКТРОННЫЕ КНИГИ (remont-elektronnyh-knig) ─────────────────────
            ['name' => 'Разбит экран',                 'slug' => 'kniga-razbit-ekran',              'service' => 'zamena-ekrana',         'cat' => 'remont-elektronnyh-knig'],
            ['name' => 'Быстро разряжается',           'slug' => 'kniga-bystro-razryazhaetsya',     'service' => 'zamena-akkumulyatora',  'cat' => 'remont-elektronnyh-knig'],
            ['name' => 'Не заряжается',                'slug' => 'kniga-ne-zaryazhaetsya',          'service' => 'zamena-razema-zaryadki','cat' => 'remont-elektronnyh-knig'],
            ['name' => 'Зависает / тормозит',          'slug' => 'kniga-zavisaet',                  'service' => 'obnovlenie-proshivki',  'cat' => 'remont-elektronnyh-knig'],
            ['name' => 'Не включается',                'slug' => 'kniga-ne-vklyuchaetsya',          'service' => 'zamena-akkumulyatora',  'cat' => 'remont-elektronnyh-knig'],

            // ── КВАДРОКОПТЕРЫ (remont-kvadrokopterov) ───────────────────────────
            ['name' => 'Быстро разряжается',           'slug' => 'kopter-bystro-razryazhaetsya',    'service' => 'zamena-akkumulyatora', 'cat' => 'remont-kvadrokopterov'],
            ['name' => 'Уводит в сторону при полёте',  'slug' => 'kopter-uvodit-v-storonu',         'service' => 'remont-gps',           'cat' => 'remont-kvadrokopterov'],
            ['name' => 'Сломаны лопасти',              'slug' => 'kopter-slomany-lopasti',          'service' => 'zamena-lopastej',      'cat' => 'remont-kvadrokopterov'],
            ['name' => 'Не работает GPS',              'slug' => 'kopter-ne-rabotaet-gps',          'service' => 'remont-gps',           'cat' => 'remont-kvadrokopterov'],
            ['name' => 'Не работает камера',           'slug' => 'kopter-ne-rabotaet-kamera',       'service' => 'remont-kamery',        'cat' => 'remont-kvadrokopterov'],
            ['name' => 'Вибрирует / не взлетает',      'slug' => 'kopter-ne-vzletaet',              'service' => 'zamena-motora',        'cat' => 'remont-kvadrokopterov'],

            // ── РОБОТЫ-ПЫЛЕСОСЫ (remont-robotov-pylesosov) ──────────────────────
            ['name' => 'Быстро разряжается',           'slug' => 'pylesос-bystro-razryazhaetsya',   'service' => 'zamena-akkumulyatora', 'cat' => 'remont-robotov-pylesosov'],
            ['name' => 'Не едет / застревает',         'slug' => 'pylesос-ne-edet',                 'service' => 'zamena-koles',         'cat' => 'remont-robotov-pylesosov'],
            ['name' => 'Плохо убирает',                'slug' => 'pylesoc-ploho-ubiraet',           'service' => 'zamena-shhetok',       'cat' => 'remont-robotov-pylesosov'],
            ['name' => 'Не ориентируется в пространстве', 'slug' => 'pylesoc-ne-orientiruetsya',    'service' => 'remont-datchikov',     'cat' => 'remont-robotov-pylesosov'],
            ['name' => 'Не включается',                'slug' => 'pylesoc-ne-vklyuchaetsya',        'service' => 'remont-platy',         'cat' => 'remont-robotov-pylesosov'],
            ['name' => 'Сильно шумит',                 'slug' => 'pylesoc-silno-shumit',            'service' => 'zamena-shhetok',       'cat' => 'remont-robotov-pylesosov'],

            // ── ТЕРМИНАЛЫ СБОРА ДАННЫХ (remont-terminalov-sbora-dannyh) ─────────
            ['name' => 'Разбит экран',                 'slug' => 'terminal-razbit-ekran',           'service' => 'zamena-ekrana',         'cat' => 'remont-terminalov-sbora-dannyh'],
            ['name' => 'Быстро разряжается',           'slug' => 'terminal-bystro-razryazhaetsya',  'service' => 'zamena-akkumulyatora',  'cat' => 'remont-terminalov-sbora-dannyh'],
            ['name' => 'Попала вода',                  'slug' => 'terminal-popala-voda',            'service' => 'remont-posle-zalitiya', 'cat' => 'remont-terminalov-sbora-dannyh'],
            ['name' => 'Не работает клавиатура',       'slug' => 'terminal-ne-rabotaet-klaviatura', 'service' => 'zamena-klaviatury',     'cat' => 'remont-terminalov-sbora-dannyh'],
            ['name' => 'Не сканирует штрих-коды',      'slug' => 'terminal-ne-skaniruet',           'service' => 'remont-skanera',        'cat' => 'remont-terminalov-sbora-dannyh'],
            ['name' => 'Не включается',                'slug' => 'terminal-ne-vklyuchaetsya',       'service' => 'zamena-akkumulyatora',  'cat' => 'remont-terminalov-sbora-dannyh'],
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
        $slugs = [
            'telefon-carap-steklo-kamery', 'telefon-zabyt-parol',
            'planshet-carap-steklo-kamery', 'planshet-zabyt-parol',
            'chasy-razbita-kryshka', 'chasy-zabyt-parol',
            'pc-silno-greetsya', 'pc-ne-vidit-disk', 'pc-ne-vklyuchaetsya', 'pc-zavisaet',
            'pc-bsod', 'pc-ne-rabotaet-ram', 'pc-net-izobrazheniya', 'pc-ne-rabotaet-mb',
            'pc-poterya-dannyh', 'pc-shumit-ventilator',
            'monitor-razbit-ekran', 'monitor-ne-vklyuchaetsya', 'monitor-net-podsvetki',
            'monitor-polosy-na-ekrane', 'monitor-migaet-izobrazhenie', 'monitor-net-izobrazheniya',
            'monoblok-razbit-ekran', 'monoblok-silno-greetsya', 'monoblok-ne-vidit-disk',
            'monoblok-ne-vklyuchaetsya', 'monoblok-zavisaet', 'monoblok-shumit-ventilator',
            'tv-razbit-ekran', 'tv-ne-vklyuchaetsya', 'tv-net-podsvetki',
            'tv-polosy-na-ekrane', 'tv-zavisaet', 'tv-net-izobrazheniya', 'tv-net-zvuka',
            'pristavka-silno-greetsya', 'pristavka-ne-vklyuchaetsya', 'pristavka-ne-chitaet-diski',
            'pristavka-zavisaet', 'pristavka-krasnyj-indikator', 'pristavka-tormozit',
            'dzhojstik-bystro-razryazhaetsya', 'dzhojstik-ne-zaryazhaetsya',
            'dzhojstik-ne-rabotaet-vibraciya', 'dzhojstik-drejf-stika',
            'dzhojstik-ne-nazhimayutsya-knopki', 'dzhojstik-zalipaet-stik',
            'naushniki-bystro-razryazhaetsya', 'naushniki-net-zvuka', 'naushniki-tihij-zvuk',
            'naushniki-ne-zaryazhaetsya', 'naushniki-tresk', 'naushniki-porvalis-ambushyury',
            'kolonka-bystro-razryazhaetsya', 'kolonka-ne-zaryazhaetsya', 'kolonka-popala-voda',
            'kolonka-hripit', 'kolonka-ne-vklyuchaetsya', 'kolonka-tresk',
            'foto-razbit-ekran', 'foto-bystro-razryazhaetsya', 'foto-mutnye-foto',
            'foto-ne-srabatyvaet-zatvor', 'foto-ne-fokusiruetsya', 'foto-pyatna-na-foto',
            'ob-ne-fokusiruetsya', 'ob-gribok-i-pyl', 'ob-ne-rabotaet-stabilizator',
            'ob-ne-rabotaet-diafragma', 'ob-sloman-bajonet', 'ob-zaedaet-zum',
            'vspyshka-ne-zaryazhaetsya', 'vspyshka-ne-srabatyvaet',
            'vspyshka-dolgo-zaryazhaetsya', 'vspyshka-ne-vklyuchaetsya',
            'kniga-razbit-ekran', 'kniga-bystro-razryazhaetsya', 'kniga-ne-zaryazhaetsya',
            'kniga-zavisaet', 'kniga-ne-vklyuchaetsya',
            'kopter-bystro-razryazhaetsya', 'kopter-uvodit-v-storonu', 'kopter-slomany-lopasti',
            'kopter-ne-rabotaet-gps', 'kopter-ne-rabotaet-kamera', 'kopter-ne-vzletaet',
            'pylesoc-bystro-razryazhaetsya', 'pylesoc-ne-edet', 'pylesoc-ploho-ubiraet',
            'pylesoc-ne-orientiruetsya', 'pylesoc-ne-vklyuchaetsya', 'pylesoc-silno-shumit',
            'terminal-razbit-ekran', 'terminal-bystro-razryazhaetsya', 'terminal-popala-voda',
            'terminal-ne-rabotaet-klaviatura', 'terminal-ne-skaniruet', 'terminal-ne-vklyuchaetsya',
        ];

        DB::table('defects')->whereIn('slug', $slugs)->delete();
    }
};
