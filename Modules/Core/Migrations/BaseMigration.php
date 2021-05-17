<?php

namespace Modules\Core\Migrations;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class BaseMigration extends Migration
{
    public function getSchema()
    {
        $schema = DB::connection()->getSchemaBuilder();
        $schema->blueprintResolver(function ($table, $callback) {
            return new ModuleBluePrint($table, $callback);
        });
        return $schema;
    }
}
