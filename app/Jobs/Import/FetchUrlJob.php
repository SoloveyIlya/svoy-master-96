<?php

namespace App\Jobs\Import;

use App\Models\ImportUrl;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FetchUrlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public array $backoff = [10, 30, 60];

    public function __construct(
        public int $urlId,
    ) {}

    public function handle(): void
    {
        $importUrl = ImportUrl::findOrFail($this->urlId);

        if ($importUrl->status !== 'new') {
            return;
        }

        Log::info("[Parser] FetchUrlJob: fetching URL #{$importUrl->id} — {$importUrl->url}");

        $this->throttle();

        try {
            $response = Http::timeout(30)
                ->withHeaders(['User-Agent' => 'SvoyMasterParser/1.0'])
                ->get($importUrl->url);

            $html = $response->body();
            $hash = md5($html);

            $storagePath = "parser/html/{$importUrl->import_run_id}/{$importUrl->id}.html";
            Storage::put($storagePath, $html);

            $importUrl->update([
                'status' => 'fetched',
                'http_code' => $response->status(),
                'content_hash' => $hash,
                'raw_path' => $storagePath,
                'last_fetched_at' => now(),
            ]);

            $importUrl->importRun->incrementStat('urls_fetched', 1);

            Log::info("[Parser] FetchUrlJob: URL #{$importUrl->id} fetched (HTTP {$response->status()})");

            ParseHtmlJob::dispatch($importUrl->id)
                ->onQueue('parser');

        } catch (\Throwable $e) {
            $importUrl->markFailed($e->getMessage());
            $importUrl->importRun->incrementStat('errors', 1);
            Log::error("[Parser] FetchUrlJob failed for URL #{$importUrl->id}: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Простой rate limiter — пауза между HTTP-запросами.
     * При использовании Redis можно заменить на Cache::lock / RateLimiter.
     */
    private function throttle(): void
    {
        $cacheKey = 'parser_last_request_at';
        $lastRequestAt = cache($cacheKey);

        if ($lastRequestAt) {
            $elapsed = microtime(true) - (float) $lastRequestAt;
            $delay = max(0, 1.0 - $elapsed);
            if ($delay > 0) {
                usleep((int) ($delay * 1_000_000));
            }
        }

        cache([$cacheKey => microtime(true)], now()->addMinutes(5));
    }
}
