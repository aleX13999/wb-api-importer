<?php

namespace App\Console\Commands;

use App\Application\Company\DTO\CompanyCreateData;
use App\Application\Company\Exception\CompanyValidationException;
use App\Application\Company\Service\CompanyCreator;
use Illuminate\Console\Command;

class CreateCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-company {name: The name of the company}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new company';

    public function __construct(
        private readonly CompanyCreator $creator,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $createData = new CompanyCreateData();
        $createData
            ->setName($this->argument('name'));

        try {
            $this->creator->create($createData);
        } catch (CompanyValidationException $exception) {
            $this->error($exception->getMessage());
        }
    }
}
