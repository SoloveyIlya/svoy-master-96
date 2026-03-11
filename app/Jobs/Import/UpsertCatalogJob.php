<?php

namespace App\Jobs\Import;

use App\Models\Brand;
use App\Models\Category;
use App\Models\DeviceModel;
use App\Models\ImportItem;
use App\Models\LandingPage;
use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UpsertCatalogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public array $backoff = [5, 15, 30];

    public function __construct(
        public int $itemId,
    ) {}

    public function handle(): void
    {
        $item = ImportItem::with('importRun')->findOrFail($this->itemId);
        $payload = $item->payload_json;
        $runId = $item->import_run_id;

        Log::info("[Parser] UpsertCatalogJob: processing ImportItem #{$item->id}");

        try {
            $categoryName = $payload['category'] ?? null;
            $brandName = $payload['brand'] ?? null;
            $modelName = $payload['model'] ?? null;
            $serviceName = $payload['service_name'] ?? null;

            if (!$categoryName || !$brandName || !$modelName || !$serviceName) {
                Log::warning("[Parser] UpsertCatalogJob: incomplete payload for item #{$item->id}");
                $item->importRun->incrementStat('skipped', 1);
                return;
            }

            $category = Category::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => $categoryName, 'status' => 'active']
            );

            $brand = Brand::firstOrCreate(
                ['slug' => Str::slug($brandName)],
                ['name' => $brandName, 'status' => 'active']
            );

            $service = Service::firstOrCreate(
                ['slug' => Str::slug($serviceName)],
                [
                    'name' => $serviceName,
                    'status' => 'active',
                    'price_from' => $payload['price'] ?? null,
                    'duration_text' => $payload['duration'] ?? null,
                    'warranty_text' => $payload['warranty'] ?? null,
                ]
            );

            $deviceModel = DeviceModel::updateOrCreate(
                [
                    'slug' => Str::slug($modelName),
                    'brand_id' => $brand->id,
                    'category_id' => $category->id,
                ],
                [
                    'name' => $modelName,
                    'status' => 'active',
                    'import_run_id' => $runId,
                ]
            );

            // Формируем slug с category + brand + model, чтобы исключить конфликты.
            $landingSlug = Str::slug($serviceName . ' ' . $categoryName . ' ' . $brandName . ' ' . $modelName);

            $landingPage = LandingPage::updateOrCreate(
                [
                    'model_id' => $deviceModel->id,
                    'service_id' => $service->id,
                ],
                [
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'slug' => $landingSlug,
                    'price_from' => (string) ($payload['price'] ?? ''),
                    'status' => 'active',
                    'import_run_id' => $runId,
                ]
            );

            $wasRecentlyCreated = $landingPage->wasRecentlyCreated;
            $item->importRun->incrementStat($wasRecentlyCreated ? 'new' : 'updated', 1);

            Log::info("[Parser] UpsertCatalogJob: item #{$item->id} → " .
                "Category '{$category->name}', Brand '{$brand->name}', " .
                "Model '{$deviceModel->name}', Service '{$service->name}', " .
                "Landing #{$landingPage->id} (" . ($wasRecentlyCreated ? 'NEW' : 'UPDATED') . ")");

        } catch (\Throwable $e) {
            $item->importRun->incrementStat('errors', 1);
            Log::error("[Parser] UpsertCatalogJob failed for item #{$item->id}: {$e->getMessage()}");
            throw $e;
        }
    }
}
