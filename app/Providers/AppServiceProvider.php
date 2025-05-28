<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Client\ClientService;
use App\Services\Client\ClientServiceInterface;
use App\Repositories\Client\ClientRepositoryInterface;
use App\Repositories\Client\ClientRepository;
use App\Services\Project\ProjectService;
use App\Services\Project\ProjectServiceInterface;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Repositories\Project\ProjectRepository;
use App\Services\TimeLog\TimeLogService;
use App\Services\TimeLog\TimeLogServiceInterface;
use App\Repositories\TimeLog\TimeLogRepositoryInterface;
use App\Repositories\TimeLog\TimeLogRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register Client services and repositories
        $this->app->bind(ClientServiceInterface::class, ClientService::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);

        // Register Project services and repositories
        $this->app->bind(ProjectServiceInterface::class, ProjectService::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);

        // Register TimeLog services and repositories
        $this->app->bind(TimeLogServiceInterface::class, TimeLogService::class);
        $this->app->bind(TimeLogRepositoryInterface::class, TimeLogRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
