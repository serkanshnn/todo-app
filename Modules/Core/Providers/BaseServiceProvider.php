<?php

namespace Modules\Core\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Core\Exception\NotImplementedException;
use Illuminate\Support\ServiceProvider;

class BaseServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $moduleName;

    /**
     * @var string
     */
    protected $moduleNameLower;

    /**
     * @var string
     */
    protected $modulePath;

    protected function setModuleName(string $moduleName)
    {
        $this->moduleName = $moduleName;
        $this->moduleNameLower = strtolower($moduleName);
        $this->modulePath = app('modules')->find($this->moduleName)->getPath();
    }

    private function checkModuleName()
    {
        if (empty($this->moduleName)) {
            throw new NotImplementedException('Please call setModuleName method in boot method of your XXXServiceProvider class');
        }
    }

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->checkModuleName();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        //$this->registerFactories();

        $this->loadMigrationsFrom($this->modulePath.'/Database/Migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->checkModuleName();
        $this->publishes([$this->modulePath.'/Config/config.php' => config_path($this->moduleNameLower.'.php')], 'config');
        $this->mergeConfigFrom($this->modulePath.'/Config/config.php', $this->moduleNameLower);
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $this->checkModuleName();
        $viewPath = resource_path('views/modules/'.$this->moduleNameLower);

        $sourcePath = $this->modulePath.'/Resources/views';

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path.'/modules/'.$this->moduleNameLower;
        }, \Config::get('view.paths')), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $this->checkModuleName();
        $langPath = resource_path('lang/modules/'.$this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        $this->checkModuleName();
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path($this->moduleName, 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $this->checkModuleName();
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path.'/modules/'.$this->moduleNameLower)) {
                $paths[] = $path.'/modules/'.$this->moduleNameLower;
            }
        }

        return $paths;
    }

    public static function registerNova()
    {
    }
}
