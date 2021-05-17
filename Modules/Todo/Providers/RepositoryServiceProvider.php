<?php

namespace Modules\Todo\Providers;

use Modules\Todo\Repositories\Todo\TodoRepository;
use Modules\Todo\Repositories\Todo\TodoRepositoryInterface;
use Modules\Todo\Services\Todo\TodoService;
use Modules\Todo\Services\Todo\TodoServiceInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //repositories
        $this->app->bind(TodoRepositoryInterface::class, TodoRepository::class);

        //services
        $this->app->bind(TodoServiceInterface::class, TodoService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
