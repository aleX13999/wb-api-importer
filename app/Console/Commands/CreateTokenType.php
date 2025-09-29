<?php

namespace App\Console\Commands;

use App\Application\TokenType\DTO\TokenTypeCreateData;
use App\Application\TokenType\Exception\TokenTypeValidationException;
use App\Application\TokenType\Service\TokenTypeCreator;
use Illuminate\Console\Command;

class CreateTokenType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-token-type {name: The name of the token type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new token type';

    public function __construct(
        private readonly TokenTypeCreator $creator,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $createData = new TokenTypeCreateData();
        $createData
            ->setName($this->argument('name'));

        try {
            $this->creator->create($createData);
        } catch (TokenTypeValidationException $exception) {
            $this->error($exception->getMessage());
        }
    }
}
