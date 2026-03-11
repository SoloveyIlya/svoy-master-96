<?php

namespace App\Jobs\Import;

use App\Models\ImportRun;
use App\Models\ImportUrl;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DiscoverUrlsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 1;

    public function __construct(
        public string $seedUrl,
        public string $initiatedBy = 'system',
    ) {}

    public function handle(): void
    {
        $run = ImportRun::create([
            'started_at' => now(),
            'status' => 'running',
            'initiated_by' => $this->initiatedBy,
        ]);

        Log::info("[Parser] ImportRun #{$run->id} started. Seed: {$this->seedUrl}");

        try {
            $discoveredUrls = $this->discoverUrls($this->seedUrl);

            foreach ($discoveredUrls as $urlData) {
                $importUrl = ImportUrl::create([
                    'import_run_id' => $run->id,
                    'url' => $urlData['url'],
                    'type' => $urlData['type'],
                    'status' => 'new',
                ]);

                FetchUrlJob::dispatch($importUrl->id)
                    ->onQueue('parser');
            }

            $run->incrementStat('urls_discovered', count($discoveredUrls));

            Log::info("[Parser] ImportRun #{$run->id}: discovered " . count($discoveredUrls) . " URLs");

            FinalizeImportRunJob::dispatch($run->id)
                ->delay(now()->addMinutes(5))
                ->onQueue('parser');

        } catch (\Throwable $e) {
            $run->update(['status' => 'failed', 'finished_at' => now()]);
            $run->incrementStat('errors', 1);
            Log::error("[Parser] DiscoverUrlsJob failed for run #{$run->id}: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Заглушка: в будущем здесь будет реальный краулинг seed URL.
     * Сейчас возвращает мок-массив URL-ов для тестирования конвейера.
     *
     * @return array<int, array{url: string, type: string}>
     */
    private function discoverUrls(string $seedUrl): array
    {
        // TODO: реализовать HTTP-запрос к seedUrl, парсинг HTML,
        // извлечение ссылок на категории, модели, страницы услуг.

        return [
            ['url' => $seedUrl . '/phones/apple/iphone-14-pro', 'type' => 'service_page'],
            ['url' => $seedUrl . '/phones/samsung/galaxy-s24', 'type' => 'service_page'],
            ['url' => $seedUrl . '/phones', 'type' => 'category'],
        ];
    }
}
