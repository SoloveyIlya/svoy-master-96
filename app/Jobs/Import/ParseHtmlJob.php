<?php

namespace App\Jobs\Import;

use App\Models\ImportItem;
use App\Models\ImportUrl;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ParseHtmlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 1;

    private const PARSER_VERSION = '1.0-mock';

    public function __construct(
        public int $urlId,
    ) {}

    public function handle(): void
    {
        $importUrl = ImportUrl::findOrFail($this->urlId);

        if ($importUrl->status !== 'fetched') {
            return;
        }

        Log::info("[Parser] ParseHtmlJob: parsing URL #{$importUrl->id}");

        try {
            $html = $importUrl->raw_path
                ? Storage::get($importUrl->raw_path)
                : null;

            if (!$html) {
                $importUrl->markFailed('HTML file not found in storage');
                return;
            }

            // TODO: заменить на реальный DOM Crawler парсинг.
            // Сейчас возвращаем захардкоженные мок-данные для тестирования конвейера.
            $payload = $this->parseHtml($html, $importUrl->type);

            $item = ImportItem::create([
                'import_run_id' => $importUrl->import_run_id,
                'source_url_id' => $importUrl->id,
                'payload_json' => $payload,
                'parsed_at' => now(),
                'parser_version' => self::PARSER_VERSION,
            ]);

            $importUrl->update(['status' => 'parsed']);
            $importUrl->importRun->incrementStat('urls_parsed', 1);

            Log::info("[Parser] ParseHtmlJob: URL #{$importUrl->id} parsed → ImportItem #{$item->id}");

            UpsertCatalogJob::dispatch($item->id)
                ->onQueue('parser');

        } catch (\Throwable $e) {
            $importUrl->markFailed($e->getMessage());
            $importUrl->importRun->incrementStat('errors', 1);
            Log::error("[Parser] ParseHtmlJob failed for URL #{$importUrl->id}: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Мок-парсер: возвращает фейковые данные вместо реального DOM-парсинга.
     * Формат payload соответствует структуре ТЗ.
     */
    private function parseHtml(string $html, string $urlType): array
    {
        // TODO: использовать Symfony DomCrawler для извлечения данных из $html
        // по CSS-селекторам. Пока — хардкод для проверки конвейера.

        return [
            'category' => 'Телефоны',
            'brand' => 'Apple',
            'model' => 'iPhone 14 Pro',
            'service_name' => 'Замена экрана',
            'price' => 5000,
            'duration' => '30 минут',
            'warranty' => '1 год',
            'short_desc' => 'Оригинальный дисплей',
        ];
    }
}
