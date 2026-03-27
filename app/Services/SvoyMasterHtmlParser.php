<?php

namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Парсит HTML-страницы сайта svoymaster96.ru.
 *
 * Структура сайта: одна страница = один бренд в одной категории.
 * На странице несколько разделов: заголовок с моделью + таблица услуг/цен.
 * Паттерн заголовка: "Актуальный прайс-лист ремонта {MODEL} на :"
 */
class SvoyMasterHtmlParser
{
    /**
     * Карта URL-слагов → метаданные (категория, бренд).
     * Ключ — путь без домена (например, /apple-iphone).
     */
    private const URL_METADATA = [
        '/apple-iphone'        => ['category' => 'Смартфоны', 'brand' => 'Apple'],
        '/samsung-mobile'      => ['category' => 'Смартфоны', 'brand' => 'Samsung'],
        '/xiaomi-mobile'       => ['category' => 'Смартфоны', 'brand' => 'Xiaomi'],
        '/huawei-mobile'       => ['category' => 'Смартфоны', 'brand' => 'Huawei'],
        '/honor-mobile'        => ['category' => 'Смартфоны', 'brand' => 'Honor'],
        '/meizu-mobile'        => ['category' => 'Смартфоны', 'brand' => 'Meizu'],
        '/asus-mobile'         => ['category' => 'Смартфоны', 'brand' => 'Asus'],
        '/zte-mobile'          => ['category' => 'Смартфоны', 'brand' => 'ZTE'],
        '/lenovo-mobile'       => ['category' => 'Смартфоны', 'brand' => 'Lenovo'],
        '/sony-mobile'         => ['category' => 'Смартфоны', 'brand' => 'Sony'],

        '/ipad-planshety'      => ['category' => 'Планшеты', 'brand' => 'Apple'],
        '/sony-planshety'      => ['category' => 'Планшеты', 'brand' => 'Sony'],
        '/lenovo-planshety'    => ['category' => 'Планшеты', 'brand' => 'Lenovo'],
        '/lg-planshety'        => ['category' => 'Планшеты', 'brand' => 'LG'],
        '/asus-planshety'      => ['category' => 'Планшеты', 'brand' => 'Asus'],
        '/nokia-planshety'     => ['category' => 'Планшеты', 'brand' => 'Nokia'],
        '/samsung-planshety'   => ['category' => 'Планшеты', 'brand' => 'Samsung'],
        '/xiaomi-planshety'    => ['category' => 'Планшеты', 'brand' => 'Xiaomi'],
        '/huawei-planshety'    => ['category' => 'Планшеты', 'brand' => 'Huawei'],
        '/meizu-planshety'     => ['category' => 'Планшеты', 'brand' => 'Meizu'],

        '/noutbuk-acer'        => ['category' => 'Ноутбуки', 'brand' => 'Acer'],
        '/noutbuk-apple-macbook' => ['category' => 'Ноутбуки', 'brand' => 'Apple MacBook'],
        '/noutbuk-asus'        => ['category' => 'Ноутбуки', 'brand' => 'Asus'],
        '/noutbuk-dell'        => ['category' => 'Ноутбуки', 'brand' => 'DELL'],
        '/noutbuk-hp'          => ['category' => 'Ноутбуки', 'brand' => 'HP'],
        '/noutbuk-lenovo'      => ['category' => 'Ноутбуки', 'brand' => 'Lenovo'],
        '/noutbuk-samsung'     => ['category' => 'Ноутбуки', 'brand' => 'Samsung'],
        '/noutbuk-sony'        => ['category' => 'Ноутбуки', 'brand' => 'Sony'],
        '/noutbuk-toshiba'     => ['category' => 'Ноутбуки', 'brand' => 'Toshiba'],

        '/apple-watch'         => ['category' => 'Смарт-часы', 'brand' => 'Apple Watch'],
    ];

    /**
     * @return array<int, array{category: string, brand: string, model: string, service_name: string, price: int, duration: string|null}>
     */
    public function parse(string $html, string $url): array
    {
        $meta = $this->getMetaByUrl($url);
        if (!$meta) {
            return [];
        }

        $sections = $this->extractModelSections($html);
        if (empty($sections)) {
            return [];
        }

        $items = [];
        foreach ($sections as ['model' => $model, 'tableHtml' => $tableHtml]) {
            $services = $this->parseServiceTable($tableHtml);
            foreach ($services as $service) {
                $items[] = [
                    'category'     => $meta['category'],
                    'brand'        => $meta['brand'],
                    'model'        => $model,
                    'service_name' => $service['name'],
                    'price'        => $service['price'],
                    'duration'     => $service['duration'],
                ];
            }
        }

        return $items;
    }

    /**
     * @return array<string, string>|null
     */
    public function getMetaByUrl(string $url): ?array
    {
        $path = parse_url($url, PHP_URL_PATH) ?? '/';
        $path = rtrim($path, '/') ?: '/';

        return self::URL_METADATA[$path] ?? null;
    }

    /**
     * Возвращает список URL страниц бренда для заданного базового URL.
     *
     * @return array<int, array{url: string, type: string}>
     */
    public function discoverBrandUrls(string $baseUrl): array
    {
        $base = rtrim($baseUrl, '/');
        $urls = [];

        foreach (array_keys(self::URL_METADATA) as $path) {
            $urls[] = [
                'url'  => $base . $path,
                'type' => 'brand_page',
            ];
        }

        return $urls;
    }

    /**
     * Разбивает HTML по разделам «модель + таблица».
     * Ищет заголовки «прайс-лист ремонта {MODEL} на :» и берёт следующую <table>.
     *
     * @return array<int, array{model: string, tableHtml: string}>
     */
    private function extractModelSections(string $html): array
    {
        $sections = [];
        $htmlLower = mb_strtolower($html);

        // Найти все вхождения "прайс-лист ремонта" в нижнем регистре
        $searchStr = 'прайс-лист ремонта';
        $offset = 0;

        while (($pos = mb_strpos($htmlLower, $searchStr, $offset)) !== false) {
            // Взять фрагмент от найденной позиции для извлечения имени модели
            $fragment = mb_substr($html, $pos, 300);

            if (preg_match('/прайс.лист ремонта\s+(.+?)\s+на\s*[：:]/isu', $fragment, $matches)) {
                $rawModel = $matches[1];
                $modelName = trim(html_entity_decode(strip_tags($rawModel), ENT_QUOTES | ENT_HTML5, 'UTF-8'));

                // Найти первую <table> после этой позиции
                $bytePos = strlen(mb_substr($html, 0, $pos));
                $tableStart = strpos($html, '<table', $bytePos);

                if ($tableStart !== false) {
                    $tableEnd = strpos($html, '</table>', $tableStart);

                    if ($tableEnd !== false) {
                        $tableHtml = substr($html, $tableStart, $tableEnd - $tableStart + 8);
                        $sections[] = [
                            'model'     => $modelName,
                            'tableHtml' => $tableHtml,
                        ];
                    }
                }
            }

            $offset = $pos + mb_strlen($searchStr);
        }

        return $sections;
    }

    /**
     * Парсит таблицу услуг: Услуга | Время ремонта | Стоимость.
     *
     * @return array<int, array{name: string, duration: string|null, price: int}>
     */
    private function parseServiceTable(string $tableHtml): array
    {
        $services = [];

        try {
            $crawler = new Crawler($tableHtml);
            $rows = $crawler->filter('tr');

            $rows->each(function (Crawler $row, int $rowIndex) use (&$services) {
                // Пропускаем заголовочные строки (th)
                if ($row->filter('th')->count() > 0 && $row->filter('td')->count() === 0) {
                    return;
                }

                $cells = $row->filter('td');
                if ($cells->count() < 2) {
                    return;
                }

                $serviceName = $this->cleanText($cells->eq(0)->text());
                if (!$serviceName || mb_strlen($serviceName) < 3) {
                    return;
                }

                $duration = $cells->count() > 1
                    ? $this->cleanText($cells->eq(1)->text())
                    : null;

                // Цена: последняя ячейка или 3-я (индекс 2)
                $priceCell = $cells->count() >= 3
                    ? $cells->eq(2)->text()
                    : $cells->eq($cells->count() - 1)->text();

                // Если у нас 4+ ячеек — берём все кроме первых двух и ищем цену
                if ($cells->count() > 3) {
                    for ($i = 2; $i < $cells->count(); $i++) {
                        $candidate = $this->extractNumericPrice($cells->eq($i)->text());
                        if ($candidate !== null) {
                            $services[] = [
                                'name'     => $serviceName,
                                'duration' => $duration,
                                'price'    => $candidate,
                            ];
                            return;
                        }
                    }
                    return;
                }

                $price = $this->extractNumericPrice($priceCell);
                if ($price === null) {
                    return;
                }

                $services[] = [
                    'name'     => $serviceName,
                    'duration' => $duration,
                    'price'    => $price,
                ];
            });
        } catch (\Throwable) {
            // Молча игнорируем битый HTML
        }

        return $services;
    }

    /**
     * Извлекает числовую цену из строки.
     * Игнорирует «Звоните», «-», «---» и числа меньше 150 (минуты, номера).
     */
    private function extractNumericPrice(string $text): ?int
    {
        $text = trim($text);

        if (in_array($text, ['-', '--', '---', '—'], true)) {
            return null;
        }

        preg_match_all('/\d+/', $text, $matches);

        if (empty($matches[0])) {
            return null;
        }

        // Фильтруем числа в диапазоне реальных цен (150–200000 руб)
        $prices = array_filter(
            array_map('intval', $matches[0]),
            fn (int $n): bool => $n >= 150 && $n <= 200_000
        );

        if (empty($prices)) {
            return null;
        }

        return (int) max($prices);
    }

    private function cleanText(string $text): string
    {
        return trim(preg_replace('/\s+/u', ' ', $text) ?? $text);
    }
}
