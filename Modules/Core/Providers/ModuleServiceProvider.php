<?php

namespace Modules\Core\Providers;

use Modules\Core\Commands\Module\ControllerMakeCommand;
use Modules\Core\Commands\Module\DTOMakeCommand;
use Modules\Core\Commands\Module\ModuleMakeCommand;
use Modules\Core\Commands\Module\NovaMakeCommand;
use Modules\Core\Commands\Module\RepositoryInterfaceMakeCommand;
use Modules\Core\Commands\Module\RepositoryMakeCommand;
use Modules\Core\Commands\Module\RepositoryServiceProviderMakeCommand;
use Modules\Core\Commands\Module\ServiceInterfaceMakeCommand;
use Modules\Core\Commands\Module\ServiceMakeCommand;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $configPath = __DIR__ . '/../Config/modules.php';

        $this->publishes([
            $configPath => config_path('modules.php'),
        ], 'modules-config');

        $this->registerModuleCommands();
    }

    private function registerModuleCommands()
    {
        $this->commands([
            ModuleMakeCommand::class,
            ControllerMakeCommand::class,
            DTOMakeCommand::class,
            NovaMakeCommand::class,
            RepositoryInterfaceMakeCommand::class,
            RepositoryMakeCommand::class,
            RepositoryServiceProviderMakeCommand::class,
            ServiceInterfaceMakeCommand::class,
            ServiceMakeCommand::class,
        ]);
    }
}
