<?php

namespace Modules\Core\Commands\Module;

use Illuminate\Support\Str;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ServiceMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument being used.
     *
     * @var string
     */
    protected $argumentName = 'service';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new Service for the specified module.';

    /**
     * Get controller name.
     *
     * @return string
     */
    public function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $servicePath = GenerateConfigReader::read('service');

        return $path . $servicePath->getPath() . '/' . $this->getModuleName() . '/' . '/' . $this->getServiceName() . '.php';
    }

    /**
     * @return string
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub($this->getStubName(), [
            'MODULENAME' => $module->getStudlyName(),
            'SERVICENAME' => $this->getServiceName(),
            'OBJECT' => $this->getObjectName(),
            'NAMESPACE' => $module->getStudlyName(),
            'CLASS_NAMESPACE' => $this->getClassNamespace($module) . "\\". $this->getModuleName(),
            'CLASS' => $this->getServiceNameWithoutNamespace(),
            'LOWER_NAME' => $module->getLowerName(),
            'MODULE' => $this->getModuleName(),
            'NAME' => $this->getModuleName(),
            'STUDLY_NAME' => $module->getStudlyName(),
            'MODULE_NAMESPACE' => $this->laravel['modules']->config('namespace'),
        ]))->render();
    }

    private function getObjectName()
    {
        return str_replace('Service', '', $this->getServiceNameWithoutNamespace());
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['service', InputArgument::REQUIRED, 'The name of the Service class.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Force overwrite', null],
        ];
    }

    /**
     * @return array|string
     */
    protected function getServiceName()
    {
        $service = Str::studly($this->argument('service'));

        if (Str::contains(strtolower($service), 'service') === false) {
            $service .= 'Service';
        }

        return $service;
    }

    /**
     * @return array|string
     */
    private function getServiceNameWithoutNamespace()
    {
        return class_basename($this->getServiceName());
    }

    public function getDefaultNamespace(): string
    {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.service.namespace') ?: $module->config('paths.generator.service.path', 'Services');
    }

    /**
     * Get the stub file name based on the options.
     * @return string
     */
    private function getStubName()
    {
        $stub = '/Service/Service.stub';

        return $stub;
    }
}
