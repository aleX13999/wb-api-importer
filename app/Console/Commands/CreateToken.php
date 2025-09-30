<?php

namespace App\Console\Commands;

use App\Application\Token\DTO\TokenCreateData;
use App\Application\Token\Exception\TokenValidationException;
use App\Application\Token\Service\TokenCreator;
use Illuminate\Console\Command;

class CreateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-token
    {apiServiceId : Id of the API service}
    {tokenTypeId : Id of the token type}
    {accountId : Id of the account}
    {token : The name of the token}
    {--expires= : The expiration time of the token}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new token';

    public function __construct(
        private readonly TokenCreator $creator,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $createData = new TokenCreateData();
        $createData
            ->setApiServiceId($this->argument('apiServiceId'))
            ->setTokenTypeId($this->argument('tokenTypeId'))
            ->setAccountId($this->argument('accountId'))
            ->setToken($this->argument('token'))
            ->setPeriodExpirationAt($this->option('expires'));

        try {
            $this->creator->create($createData);
        } catch (TokenValidationException $exception) {
            $this->error($exception->getMessage());
        }
    }
}
