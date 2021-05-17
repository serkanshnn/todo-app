<?php
namespace Modules\Core\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;

/**
 * Class SwanBluePrint
 * @package Modules\Core\Migrations
 */
class ModuleBluePrint extends Blueprint
{
    /** Create id, timetstamps, created_by and updated_by columns
     *
     */
    public function defaultColumns()
    {
        $this->id();
        $this->timestamps();
        $this->bigInteger('created_by');
        $this->bigInteger('updated_by');
    }

    /**
     *
     */
    public function defaultColumnsWithoutPk()
    {
        $this->bigInteger('id');
        $this->timestamps();
        $this->bigInteger('created_by');
        $this->bigInteger('updated_by');
    }

    public function defaultContentColumns()
    {
        $this->title();
        $this->slug();
        $this->description();
    }

    /** Create a new string name column
     * @return ColumnDefinition
     */
    public function name()
    {
        return $this->string('name');
    }

    /**Create a new string title column
     * @return ColumnDefinition
     */
    public function title()
    {
        return $this->string('title');
    }

    /**Create a new string slug column
     * @return ColumnDefinition
     */
    public function slug()
    {
        return $this->string('slug');
    }

    /**Create a new string code column
     * @return ColumnDefinition
     */
    public function code()
    {
        return $this->string('code');
    }

    /**Create a new text description column
     * @return ColumnDefinition
     */
    public function description()
    {
        return $this->text('description')->nullable();
    }

    /**
     * Create a new decimal column with 18,8 precision
     *
     * @param string $column
     * @return ColumnDefinition
     */
    public function money($column)
    {
        return $this->decimal($column, 18, 8);
    }
}
