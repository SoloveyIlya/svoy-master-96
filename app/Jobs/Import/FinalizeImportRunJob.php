<?php

namespace App\Jobs\Import;

use App\Models\DeviceModel;
use App\Models\ImportRun;
use App\Models\ImportUrl;
use App\Models\LandingPage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FinalizeImportRunJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public array $backoff = [10, 30, 60];

    public function __construct(
        public int $runId,
    ) {}

    public function handle(): void
    {
        $run = ImportRun::findOrFail($this->runId);

        if ($run->status !== 'running') {
            Log::info("[Parser] FinalizeImportRunJob: run #{$run->id} already finalized ({$run->status})");
            return;
        }

        $pendingUrls = ImportUrl::where('import_run_id', $run->id)
            ->whereNotIn('status', ['parsed', 'failed'])
            ->count();

        if ($pendingUrls > 0) {
            Log::info("[Parser] FinalizeImportRunJob: run #{$run->id} has {$pendingUrls} pending URLs, retrying later");

            self::dispatch($this->runId)
                ->delay(now()->addMinutes(2))
                ->onQueue('parser');

            return;
        }

        Log::info("[Parser] FinalizeImportRunJob: finalizing run #{$run->id}");

        $deactivatedModels = DeviceModel::where('import_run_id', '!=', $run->id)
            ->whereNotNull('import_run_id')
            ->where('status', 'active')
            ->update(['status' => 'inactive']);

        $deactivatedLandings = LandingPage::where('import_run_id', '!=', $run->id)
            ->whereNotNull('import_run_id')
            ->where('status', 'active')
            ->update(['status' => 'inactive']);

        $hasErrors = ImportUrl::where('import_run_id', $run->id)
            ->where('status', 'failed')
            ->exists();

        $run->update([
            'status' => $hasErrors ? 'failed' : 'success',
            'finished_at' => now(),
        ]);

        $run->incrementStat('deactivated_models', $deactivatedModels);
        $run->incrementStat('deactivated_landings', $deactivatedLandings);

        Log::info("[Parser] ImportRun #{$run->id} finalized: " .
            "status={$run->fresh()->status}, " .
            "deactivated {$deactivatedModels} models, {$deactivatedLandings} landings");
    }
}
