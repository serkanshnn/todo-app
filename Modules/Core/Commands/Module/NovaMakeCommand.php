<?php

namespace Modules\Core\Commands\Module;

use Illuminate\Support\Str;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class NovaMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument being used.
     *
     * @var string
     */
    protected $argumentName = 'nova';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-nova';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new Nova resource for the specified module.';

    /**
     * Get controller name.
     *
     * @return string
     */
    public function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $resourcePath = GenerateConfigReader::read('nova');

        return $path.$resourcePath->getPath().'/'.$this->getResourceName().'.php';
    }

    /**
     * @return string
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub($this->getStubName(), [
            'MODULENAME'        => $module->getStudlyName(),
            'RESOURCENAME'      => $this->getResourceName(),
            'NAMESPACE'         => $module->getStudlyName(),
            'CLASS_NAMESPACE'   => $this->getClassNamespace($module),
            'CLASS'             => $this->getResourceNameWithoutNamespace(),
            'LOWER_NAME'        => $module->getLowerName(),
            'MODULE'            => $this->getModuleName(),
            'NAME'              => $this->getModuleName(),
            'STUDLY_NAME'       => $module->getStudlyName(),
            'MODULE_NAMESPACE'  => $this->laravel['modules']->config('namespace'),
        ]))->render();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['nova', InputArgument::REQUIRED, 'The name of the Nova class.'],
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
    protected function getResourceName()
    {
        return Str::studly($this->argument('nova'));
    }

    /**
     * @return array|string
     */
    private function getResourceNameWithoutNamespace()
    {
        return class_basename($this->getResourceName());
    }

    public function getDefaultNamespace() : string
    {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.nova.namespace') ?: $module->config('paths.generator.nova.path', 'Nova');
    }

    /**
     * Get the stub file name based on the options.
     * @return string
     */
    private function getStubName()
    {
        $stub = '/Nova/Nova.stub';

        return $stub;
    }
}
