<?php

namespace Modules\Core\Generators;

use Illuminate\Config\Repository as Config;
use Illuminate\Console\Command as Console;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Nwidart\Modules\Contracts\ActivatorInterface;
use Nwidart\Modules\FileRepository;
use Nwidart\Modules\Generators\ModuleGenerator as BaseGenerator;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;

class ModuleGenerator extends BaseGenerator
{
    /**
     * Generate some resources.
     */
    public function generateResources()
    {
        if (GenerateConfigReader::read('seeder')->generate() === true) {
            $this->console->call('module:make-seed', [
                'name' => $this->getName(),
                'module' => $this->getName(),
                '--master' => true,
            ]);
        }

        if (GenerateConfigReader::read('provider')->generate() === true) {
            $this->console->call('module:make-provider', [
                'name' => $this->getName() . 'ServiceProvider',
                'module' => $this->getName(),
                '--master' => true,
            ]);

            $this->console->call('module:make-repository-service-provider', [
                'repository' => 'RepositoryServiceProvider',
                'module' => $this->getName()
            ]);

            $this->console->call('module:route-provider', [
                'module' => $this->getName(),
            ]);
        }

        if (GenerateConfigReader::read('controller')->generate() === true) {
            $this->console->call('module:make-controller', [
                'controller' => 'Api/' . $this->getName() . 'ApiController',
                'module' => $this->getName(),
                '--api' => true,
            ]);
        }

        if (GenerateConfigReader::read('model')->generate() === true) {
            $this->console->call('module:make-model', [
                'model' => $this->getName(),
                'module' => $this->getName(),
                '--migration' => true,
            ]);
        }

        if (GenerateConfigReader::read('dto')->generate() === true) {
            $this->console->call('module:make-dto', [
                'dto' => $this->getName() . 'DTO',
                'module' => $this->getName(),
            ]);
        }

        if (GenerateConfigReader::read('nova')->generate() === true) {
            $this->console->call('module:make-nova', [
                'nova' => $this->getName(),
                'module' => $this->getName(),
            ]);
        }

        if (GenerateConfigReader::read('service')->generate() === true) {
            $this->console->call('module:make-service', [
                'service' => $this->getName() . 'Service',
                'module' => $this->getName(),
            ]);


            $this->console->call('module:make-serviceinterface', [
                'service' => $this->getName() . 'ServiceInterface',
                'module' => $this->getName(),
            ]);

        }

        if (GenerateConfigReader::read('repository')->generate() === true) {
            $this->console->call('module:make-repository', [
                'repository' => $this->getName() . 'Repository',
                'module' => $this->getName(),
            ]);

            $this->console->call('module:make-repositoryinterface', [
                'repository' => $this->getName() . 'RepositoryInterface',
                'module' => $this->getName(),
            ]);

        }

        if (GenerateConfigReader::read('request')->generate() === true) {
            $this->console->call('module:make-request', [
                'name' => 'Create' . $this->getName() . 'Request',
                'module' => $this->getName(),
            ]);

            $this->console->call('module:make-request', [
                'name' => 'Update' . $this->getName() . 'Request',
                'module' => $this->getName(),
            ]);
        }

        if (GenerateConfigReader::read('transformers')->generate() === true) {
            $this->console->call('module:make-resource', [
                'name' => $this->getName() . 'Resource',
                'module' => $this->getName(),
            ]);
        }
    }
}
