<?php

namespace App\Jobs\Import;

use App\Models\ImportRun;
use App\Models\ImportUrl;
use App\Services\SvoyMasterHtmlParser;
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

    public function handle(SvoyMasterHtmlParser $parser): void
    {
        $run = ImportRun::create([
            'started_at'   => now(),
            'status'       => 'running',
            'initiated_by' => $this->initiatedBy,
            'seed_url'     => $this->seedUrl,
        ]);

        Log::info("[Parser] ImportRun #{$run->id} started. Seed: {$this->seedUrl}");

        try {
            $discoveredUrls = $parser->discoverBrandUrls($this->seedUrl);

            foreach ($discoveredUrls as $urlData) {
                $importUrl = ImportUrl::create([
                    'import_run_id' => $run->id,
                    'url'           => $urlData['url'],
                    'type'          => $urlData['type'],
                    'status'        => 'new',
                ]);

                FetchUrlJob::dispatch($importUrl->id)
                    ->onQueue('parser');
            }

            $run->incrementStat('urls_discovered', count($discoveredUrls));

            Log::info("[Parser] ImportRun #{$run->id}: discovered " . count($discoveredUrls) . ' URLs');

            // Финализируем через 30 минут — достаточно для обхода всех страниц
            FinalizeImportRunJob::dispatch($run->id)
                ->delay(now()->addMinutes(30))
                ->onQueue('parser');

        } catch (\Throwable $e) {
            $run->update(['status' => 'failed', 'finished_at' => now()]);
            $run->incrementStat('errors', 1);
            Log::error("[Parser] DiscoverUrlsJob failed for run #{$run->id}: {$e->getMessage()}");
            throw $e;
        }
    }
}
