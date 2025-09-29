<?php

namespace App\Console\Commands;

use App\Application\Account\Repository\AccountRepositoryInterface;
use App\Models\Income;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Stock;
use App\Services\LoadDataService;
use DateTime;
use Illuminate\Console\Command;

class ImportDataCommand extends Command
{
    protected $signature = 'import:data {--accountId=}';

    protected $description = 'Импортирует данные из API и сохраняет в базу';

    public function __construct(
        private readonly AccountRepositoryInterface $accountRepository,
        private readonly LoadDataService            $loadDataService,
    ) {
        parent::__construct();
    }

    public function handle(): void
    {

        $this->info('Импорт данных начался');

        $accountId = $this->option('accountId');
        if ($accountId) {
            $accounts = [$this->accountRepository->getOne($accountId)];
        } else {
            $accounts = $this->accountRepository->getAll();
        }

        try {
            foreach ($accounts as $account) {
                $dateFrom = '1900-01-01';
                $dateTo = new DateTime('today');

                $this->loadDataService->loadAllData(
                    endpoint: 'sales',
                    query:    ['dateFrom' => $dateFrom, 'dateTo' => $dateTo->format('Y-m-d')],
                    saveCallback: function (array $items) {
                        foreach ($items as $item) {
                            Sale::create(
                                $item,
                            );
                        }
                    },
                );

                $this->loadDataService->loadAllData(
                    endpoint: 'orders',
                    query:    ['dateFrom' => $dateFrom, 'dateTo' => $dateTo->format('Y-m-d')],
                    saveCallback: function (array $items) {
                        foreach ($items as $item) {
                            Order::create(
                                $item,
                            );
                        }
                    },
                );

                $dateFrom = new DateTime('today');
                $this->loadDataService->loadAllData(
                    endpoint: 'stocks',
                    query:    ['dateFrom' => $dateFrom->format('Y-m-d')],
                    saveCallback: function (array $items) {
                        foreach ($items as $item) {
                            Stock::create(
                                $item,
                            );
                        }
                    },
                );

                $this->loadDataService->loadAllData(
                    endpoint: 'incomes',
                    query:    ['dateFrom' => $dateFrom, 'dateTo' => $dateTo->format('Y-m-d')],
                    saveCallback: function (array $items) {
                        foreach ($items as $item) {
                            Income::create(
                                $item,
                            );
                        }
                    },
                );
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        $this->info('Импорт данных закончен');
    }
}
