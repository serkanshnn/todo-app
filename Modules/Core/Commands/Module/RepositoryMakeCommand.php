<?php

namespace Modules\Core\Commands\Module;

use Illuminate\Support\Str;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class RepositoryMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument being used.
     *
     * @var string
     */
    protected $argumentName = 'repository';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new Repository for the specified module.';

    /**
     * Get controller name.
     *
     * @return string
     */
    public function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $repositoryPath = GenerateConfigReader::read('repository');

        return $path . $repositoryPath->getPath() . '/' . $this->getModuleName() . '/' . $this->getRepositoryName() . '.php';
    }

    /**
     * @return string
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub($this->getStubName(), [
            'MODULENAME' => $module->getStudlyName(),
            'REPOSITORYNAME' => $this->getRepositoryName(),
            'OBJECT' => $this->getObjectName(),
            'NAMESPACE' => $module->getStudlyName(),
            'CLASS_NAMESPACE' => $this->getClassNamespace($module) . "\\". $this->getModuleName(),
            'CLASS' => $this->getRepositoryNameWithoutNamespace(),
            'LOWER_NAME' => $module->getLowerName(),
            'MODULE' => $this->getModuleName(),
            'NAME' => $this->getModuleName(),
            'STUDLY_NAME' => $module->getStudlyName(),
            'MODULE_NAMESPACE' => $this->laravel['modules']->config('namespace'),
        ]))->render();
    }

    private function getObjectName()
    {
        return str_replace('Repository', '', $this->getRepositoryNameWithoutNamespace());
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['repository', InputArgument::REQUIRED, 'The name of the Repository class.'],
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
    protected function getRepositoryName()
    {
        $repository = Str::studly($this->argument('repository'));

        if (Str::contains(strtolower($repository), 'repository') === false) {
            $repository .= 'Repository';
        }

        return $repository;
    }

    /**
     * @return array|string
     */
    private function getRepositoryNameWithoutNamespace()
    {
        return class_basename($this->getRepositoryName());
    }

    public function getDefaultNamespace(): string
    {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.repository.namespace') ?: $module->config('paths.generator.repository.path', 'Repositories');
    }

    /**
     * Get the stub file name based on the options.
     * @return string
     */
    private function getStubName()
    {
        $stub = '/Repositories/Repository.stub';

        return $stub;
    }
}
