<?php

namespace Modules\Core\Traits;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class HasModuleFactory.
 */
trait HasModuleFactory
{
    use HasFactory;

    protected static function newFactory()
    {
        $pieces = explode('\\', static::class);
        $moduleName = $pieces[1];
        $modelName = $pieces[3];
        $factory = "Modules\\".$moduleName."\\Database\\factories\\".$modelName."Factory";
        return $factory::new();
    }

}
