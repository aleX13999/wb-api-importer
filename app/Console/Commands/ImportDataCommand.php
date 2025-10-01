<?php

namespace App\Console\Commands;

use App\Application\Account\Repository\AccountRepositoryInterface;
use App\Models\Account;
use App\Models\Income;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\Token;
use App\Services\GuzzleApiService;
use Carbon\Exceptions\InvalidFormatException;
use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ImportDataCommand extends Command
{
    protected $signature = 'import:data {--accountId=*} {--date= : Date of data in format YYYY-MM-DD}';

    protected $description = 'Импортирует данные из API и сохраняет в базу';

    public function __construct(
        private readonly AccountRepositoryInterface $accountRepository,
        private readonly GuzzleApiService           $apiService,
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->info('Импорт данных начался');

        $accountId = $this->option('accountId');
        $date      = $this->option('date');

        try {
            $accounts = $accountId ? $this->accountRepository->getByIds($accountId) : $this->accountRepository->getAll();

            $dateFrom = $date ? Carbon::parse($date) : now()->subDay();
            $dateTo   = $date ? Carbon::parse($date) : now();

            /** @var Account $account */
            foreach ($accounts as $account) {
                $this->info(sprintf("Аккаунт %s(%s)", $account->name, $account->id));

                $tokens = $account->tokens();

                /** @var Token $token */
                foreach ($tokens as $token) {
                    $apiService = $token->apiService();

                    $this->info(sprintf("API сервис %s(%s)", $account->name, $account->id));

                    $this->apiService->connection($apiService->base_url . '/api/', $token->token);

                    $this->loadData(
                        endpoint: 'sales',
                        query:    ['dateFrom' => $dateFrom->format('Y-m-d'), 'dateTo' => $dateTo->format('Y-m-d')],
                        saveCallback: function (array $items) use ($account) {
                            foreach ($items as $item) {
                                $item['account_id'] = $account->id;
                                Sale::updateOrInsert(
                                    $item,
                                );
                            }
                        },
                    );

                    $this->loadData(
                        endpoint: 'orders',
                        query:    ['dateFrom' => $dateFrom, 'dateTo' => $dateTo->format('Y-m-d')],
                        saveCallback: function (array $items) use ($account) {
                            foreach ($items as $item) {
                                $item['account_id'] = $account->id;
                                Order::updateOrInsert(
                                    $item,
                                );
                            }
                        },
                    );

                    $this->loadData(
                        endpoint: 'stocks',
                        query:    ['dateFrom' => $dateFrom->format('Y-m-d')],
                        saveCallback: function (array $items) use ($account) {
                            foreach ($items as $item) {
                                $item['account_id'] = $account->id;
                                Stock::updateOrInsert(
                                    $item,
                                );
                            }
                        },
                    );

                    $this->loadData(
                        endpoint: 'incomes',
                        query:    ['dateFrom' => $dateFrom, 'dateTo' => $dateTo->format('Y-m-d')],
                        saveCallback: function (array $items) use ($account) {
                            foreach ($items as $item) {
                                $item['account_id'] = $account->id;
                                Income::updateOrInsert(
                                    $item,
                                );
                            }
                        },
                    );
                }
            }
        } catch (InvalidFormatException|Exception $e) {
            $this->error($e->getMessage());
        }

        $this->info('Импорт данных закончен');
    }

    /**
     * @throws Exception
     */
    private function loadData(string $endpoint, array $query, callable $saveCallback): void
    {
        $page = 1;

        do {
            $query['page'] = $page;
            $attempt       = 0;

            do {
                try {
                    $data = $this->apiService->get($endpoint, $query);
                    break; // если успешно - выходим из цикла попыток

                } catch (ClientException $e) {
                    $response = $e->getResponse();
                    if ($response->getStatusCode() == 429) {
                        $attempt++;
                        $wait = pow(2, $attempt);

                        $this->info('Too many requests. Waiting ' . $wait . ' seconds...');
                        sleep($wait);

                        if ($attempt >= 5) {
                            throw new \Exception("Max retries reached for 429 Too Many Requests.");
                        }

                    } else {
                        throw $e;
                    }
                }
            } while (true);

            $saveCallback($data);

            if (count($data) < 500) {
                break;
            }

            $page++;
        } while (true);
    }
}
