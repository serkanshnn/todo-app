<?php

namespace Modules\Core\Providers;

use Modules\Core\Exception\NotImplementedException;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class BaseRouteServiceProvider extends ServiceProvider
{
    private string $moduleName;

    public function setModuleName(string $moduleName)
    {
        $this->moduleName = $moduleName;
        $this->moduleNamespace = 'Modules\\' . $moduleName . '\\Http\\Controllers';
        $this->namespace = $this->moduleNamespace;
    }

    private function checkModuleName()
    {
        if (empty($this->moduleNamespace)) {
            throw new NotImplementedException('Please call setModuleName method in boot method of your RouteServiceProvider class');
        }
    }


    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        $this->mapRoutesBy(true);
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        $this->mapRoutesBy(false);
    }

    private function mapRoutesBy(bool $useWeb = false)
    {
        $this->checkModuleName();
        $prefix = $useWeb ? '' : 'api';
        $middleware = $useWeb ? 'web' : 'api';
        $routeFilePath = '/Routes/' . $middleware . '.php';
        $nameSpace = $this->moduleNamespace . ($useWeb ? '' : '\Api');

        $path = app('modules')->find($this->moduleName)->getPath();
        Route::prefix($prefix)
            ->middleware($middleware)
            ->namespace($nameSpace)
            ->group($path . $routeFilePath);
    }
}
