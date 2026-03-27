<?php

namespace App\Console\Commands;

use App\Jobs\Import\DiscoverUrlsJob;
use Illuminate\Console\Command;

class ParserRunCommand extends Command
{
    protected $signature = 'parser:run {url? : Seed URL (default: https://www.svoymaster96.ru/)}';

    protected $description = 'Запустить парсинг сайта svoymaster96.ru';

    public function handle(): int
    {
        $url = $this->argument('url') ?? 'https://www.svoymaster96.ru/';

        $this->info("Запускаю парсер для: {$url}");

        DiscoverUrlsJob::dispatch($url, 'artisan')
            ->onQueue('parser');

        $this->info('Задача отправлена в очередь parser. Запустите worker: php artisan queue:work --queue=parser');

        return self::SUCCESS;
    }
}
