<?php

namespace App\Providers;

use App\Application\Account\Repository\AccountRepositoryInterface;
use App\Application\ApiService\Repository\ApiServiceRepositoryInterface;
use App\Application\Company\Repository\CompanyRepositoryInterface;
use App\Application\Token\Repository\TokenRepositoryInterface;
use App\Application\TokenType\Repository\TokenTypeRepositoryInterface;
use App\Repositories\AccountRepository;
use App\Repositories\ApiServiceRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\TokenRepository;
use App\Repositories\TokenTypeRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(AccountRepositoryInterface::class, AccountRepository::class);
        $this->app->bind(TokenTypeRepositoryInterface::class, TokenTypeRepository::class);
        $this->app->bind(ApiServiceRepositoryInterface::class, ApiServiceRepository::class);
        $this->app->bind(TokenRepositoryInterface::class, TokenRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
