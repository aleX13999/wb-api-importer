<?php

namespace App\Console\Commands;

use App\Application\ApiService\DTO\ApiServiceCreateData;
use App\Application\ApiService\Exception\ApiServiceValidationException;
use App\Application\ApiService\Service\ApiServiceCreator;
use Illuminate\Console\Command;

class CreateApiService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-api-service {name : The name of the API service} {base_url : The URL of the API service}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new API service';

    public function __construct(
        private readonly ApiServiceCreator $creator,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $createData = new ApiServiceCreateData();
        $createData
            ->setName($this->argument('name'))
            ->setBaseUrl($this->argument('base_url'));

        try {
            $this->creator->create($createData);
        } catch (ApiServiceValidationException $exception) {
            $this->error($exception->getMessage());
        }
    }
}
