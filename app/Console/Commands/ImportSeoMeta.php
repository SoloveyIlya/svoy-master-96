<?php

namespace App\Console\Commands;

use App\Models\SeoMetadata;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportSeoMeta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo:import-meta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import SEO meta tags and H1 from app/imports/meta.csv';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = base_path('app/imports/meta.csv');

        if (!file_exists($filePath)) {
            $this->error("File not found at: {$filePath}");
            return 1;
        }

        $file = fopen($filePath, 'r');
        
        // Skip header
        $header = fgetcsv($file);
        
        $rows = [];
        while (($data = fgetcsv($file)) !== false) {
            $rows[] = $data;
        }
        fclose($file);

        $this->output->progressStart(count($rows));

        foreach ($rows as $row) {
            // [0] URL
            // [1] Текущий H1 (игнорируем)
            // [2] Новый H1 (Если пусто — берем из "Текущий H1")
            // [3] Title
            // [4] Description
            
            $url = $row[0] ?? '';
            $currentH1 = $row[1] ?? '';
            $newH1 = $row[2] ?? '';
            $title = $row[3] ?? '';
            $description = $row[4] ?? '';

            // Parse URL to get path
            $urlPath = parse_url($url, PHP_URL_PATH);
            
            // For the home page, path might be empty or null
            if (empty($urlPath) || $urlPath === '') {
                $urlPath = '/';
            }

            // Remove leading slash if it's not just "/"
            if ($urlPath !== '/' && str_starts_with($urlPath, '/')) {
                $urlPath = ltrim($urlPath, '/');
            }

            $h1 = !empty($newH1) ? $newH1 : $currentH1;

            SeoMetadata::updateOrCreate(
                ['url_path' => $urlPath],
                [
                    'h1' => $h1,
                    'title' => $title,
                    'description' => $description,
                ]
            );

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
        $this->info('SEO metadata imported successfully.');

        return 0;
    }
}
