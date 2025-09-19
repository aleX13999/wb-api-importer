<?php

namespace App\Jobs;

use App\Models\Sale;
use App\Services\LoadDataService;
use DateTime;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportSalesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     * @throws \Exception
     */
    public function handle(LoadDataService $loadDataService): void
    {
        $dateFrom = '1900-01-01';
        $dateTo   = new DateTime('today');

        $loadDataService->loadAllData(
            'sales', ['dateFrom' => $dateFrom, 'dateTo' => $dateTo->format('Y-m-d')], function (array $items)
        {
            foreach ($items as $item) {
                Sale::updateOrCreate(
                    $item,
                );
            }
        },
        );
    }
}
