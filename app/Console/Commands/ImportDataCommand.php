<?php

namespace App\Console\Commands;

use App\Jobs\ImportIncomesJob;
use App\Jobs\ImportOrdersJob;
use App\Jobs\ImportSalesJob;
use App\Jobs\ImportStocksJob;
use Illuminate\Console\Command;

class ImportDataCommand extends Command
{
    protected $signature = 'import:data';

    protected $description = 'Импортирует данные из API и сохраняет в базу';

    public function handle(): void
    {
        try {
            ImportSalesJob::dispatch();
            ImportOrdersJob::dispatch();
            ImportStocksJob::dispatch();
            ImportIncomesJob::dispatch();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        $this->info('Импорт данных запущен');
    }
}
