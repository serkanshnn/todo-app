<?php

namespace Modules\Core\Commands\Module;

use Illuminate\Support\Str;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class DTOMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument being used.
     *
     * @var string
     */
    protected $argumentName = 'dto';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-dto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new DTO for the specified module.';

    /**
     * Get controller name.
     *
     * @return string
     */
    public function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $dtoPath = GenerateConfigReader::read('dto');

        return $path.$dtoPath->getPath().'/'.$this->getModuleName().'/'.$this->getDTOName().'.php';
    }

    /**
     * @return string
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub($this->getStubName(), [
            'MODULENAME'        => $module->getStudlyName(),
            'DTONAME'           => $this->getDTOName(),
            'NAMESPACE'         => $module->getStudlyName(),
            'CLASS_NAMESPACE'   => $this->getClassNamespace($module) . "\\". $this->getModuleName(),
            'CLASS'             => $this->getDTONameWithoutNamespace(),
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
            ['dto', InputArgument::REQUIRED, 'The name of the DTO class.'],
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
    protected function getDTOName()
    {
        $dto = Str::studly($this->argument('dto'));

        if (Str::contains(strtolower($dto), 'dto') === false) {
            $dto .= 'DTO';
        }

        return $dto;
    }

    /**
     * @return array|string
     */
    private function getDTONameWithoutNamespace()
    {
        return class_basename($this->getDTOName());
    }

    public function getDefaultNamespace() : string
    {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.dto.namespace') ?: $module->config('paths.generator.dto.path', 'DTO');
    }

    /**
     * Get the stub file name based on the options.
     * @return string
     */
    private function getStubName()
    {
        $stub = '/DTO/DTO.stub';

        return $stub;
    }
}
