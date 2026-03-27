<?php

namespace App\Jobs\Import;

use App\Models\ImportItem;
use App\Models\ImportUrl;
use App\Services\SvoyMasterHtmlParser;
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

    private const PARSER_VERSION = '2.0';

    public function __construct(
        public int $urlId,
    ) {}

    public function handle(SvoyMasterHtmlParser $parser): void
    {
        $importUrl = ImportUrl::findOrFail($this->urlId);

        if ($importUrl->status !== 'fetched') {
            return;
        }

        Log::info("[Parser] ParseHtmlJob: parsing URL #{$importUrl->id} — {$importUrl->url}");

        try {
            $html = $importUrl->raw_path
                ? Storage::get($importUrl->raw_path)
                : null;

            if (!$html) {
                $importUrl->markFailed('HTML file not found in storage');
                return;
            }

            $parsedItems = $parser->parse($html, $importUrl->url);

            if (empty($parsedItems)) {
                Log::warning("[Parser] ParseHtmlJob: no items parsed from URL #{$importUrl->id} ({$importUrl->url})");
                $importUrl->update(['status' => 'parsed']);
                return;
            }

            $createdCount = 0;
            foreach ($parsedItems as $payload) {
                $item = ImportItem::create([
                    'import_run_id'  => $importUrl->import_run_id,
                    'source_url_id'  => $importUrl->id,
                    'payload_json'   => $payload,
                    'parsed_at'      => now(),
                    'parser_version' => self::PARSER_VERSION,
                ]);

                UpsertCatalogJob::dispatch($item->id)
                    ->onQueue('parser');

                $createdCount++;
            }

            $importUrl->update(['status' => 'parsed']);
            $importUrl->importRun->incrementStat('urls_parsed', 1);
            $importUrl->importRun->incrementStat('items_extracted', $createdCount);

            Log::info("[Parser] ParseHtmlJob: URL #{$importUrl->id} → {$createdCount} items");

        } catch (\Throwable $e) {
            $importUrl->markFailed($e->getMessage());
            $importUrl->importRun->incrementStat('errors', 1);
            Log::error("[Parser] ParseHtmlJob failed for URL #{$importUrl->id}: {$e->getMessage()}");
            throw $e;
        }
    }
}
