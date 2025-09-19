<?php

namespace App\Jobs;

use App\Models\Stock;
use App\Services\LoadDataService;
use DateTime;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportStocksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     * @throws \Exception
     */
    public function handle(LoadDataService $loadDataService): void
    {
        $dateFrom = new DateTime('today');

        $loadDataService->loadAllData(
            'stocks', ['dateFrom' => $dateFrom], function (array $items)
        {
            foreach ($items as $item) {
                Stock::updateOrCreate(
                    $item,
                );
            }
        },
        );
    }
}
