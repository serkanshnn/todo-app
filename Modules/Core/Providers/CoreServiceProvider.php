<?php

namespace Modules\Core\Providers;

use Modules\Core\DTO\Base\BaseDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
    }

    public function register()
    {
        parent::register();

        Collection::macro('toListDTO', function ($type) {
            return (new BaseDTO())->toList($this, $type);
        });
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/core');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'core');
        } else {
            $this->loadTranslationsFrom(module_path('core', 'Resources/lang'), 'core');
        }
    }
}
