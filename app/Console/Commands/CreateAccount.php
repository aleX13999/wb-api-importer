<?php

namespace App\Console\Commands;

use App\Application\Account\DTO\AccountCreateData;
use App\Application\Account\Exception\AccountValidationException;
use App\Application\Account\Service\AccountCreator;
use Illuminate\Console\Command;

class CreateAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-account {companyId: Id of the company} {name: The name of the account}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new account';

    public function __construct(
        private readonly AccountCreator $creator,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $createData = new AccountCreateData();
        $createData
            ->setCompanyId($this->argument('companyId'))
            ->setName($this->argument('name'));

        try {
            $this->creator->create($createData);
        } catch (AccountValidationException $exception) {
            $this->error($exception->getMessage());
        }
    }
}
