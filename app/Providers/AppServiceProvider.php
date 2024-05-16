<?php

namespace App\Providers;

use App\Services\EmployeeService;
use App\Services\Interfaces\EmployeeServiceInterface;
use App\Services\Interfaces\WorkTimeServiceInterface;
use App\Services\WorkTimeService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EmployeeServiceInterface::class, EmployeeService::class);
        $this->app->bind(WorkTimeServiceInterface::class, WorkTimeService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
