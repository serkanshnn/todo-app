<?php

namespace Modules\Core\Repositories\Base;

use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    /** it does create a record according to the array you will pass.
     * @param array $attributes
     */
    public function create(array $attributes);

    /** it does create a record according to the array you will pass.
     * @param array $attributes
     */
    public function createWithFilters(array $filters, array $data);

    /** it does update according to the array you will pass.
     * @param int $id
     * @param array $attributes
     * @return bool
     */
    public function update(int $id, array $attributes): bool;

    /** it does update according to the array you will pass.
     * @param array $attributes
     * @return bool
     */
    public function updateWith(array $attributes): bool;

    /** it does update according to the array you will pass according to filters.
     * @param array $filters
     * @param array $attributes
     * @return bool
     */
    public function updateWithFilters(array $filters, array $attributes): bool;

    /** it does update according to the array you will pass.
     * @param string $column
     * @param string $columnValue
     * @param array $data
     * @return bool
     */
    public function updateWhere(string $column, string $columnValue, array $data): bool;

    /** it fetch all data from database.
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function all($columns = ['*'], string $orderBy = 'id', string $sortBy = 'asc'): Collection;

    /** it fetch all data from database according to filters.
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @param array $filters
     * @return Collection
     */
    public function allWithFilter($columns, string $orderBy, string $sortBy, array $filters): Collection;

    /**
     * @param string $column
     * @param string $columnValue
     * @return object
     */
    public function where(string $column, string $columnValue): object;

    /**
     * @param $column
     * @param null $operator
     * @param null $value
     * @return object
     */
    public function whereQuery($column, $operator = null, $value = null): object;

    /** it find just one record from db according to the id you will pass.
     * @param $id
     */
    public function find($id);

    /** it find just one record from db according to the filter you will pass.
     * @param $filters
     */
    public function findWithFilter(array $filters);


    /**it find just one record from db according to the id you will pass
     * if it is doesn't fetch it will be throw exception
     * @param $id
     */
    public function findOrFail($id);

    /**it fetch records from db according to the conditions you will pass
     * @param array $data
     */
    public function findBy(array $data);

    /**it fetch records from db according to the id
     * @param int $id
     */
    public function findById(int $id);

    /**it fetch just one record from db according to the conditions you will pass
     * @param array $data
     */
    public function first(array $data);

    /**it fetch just one record from db according to the id you will pass
     * if it is doesn't fetch it will be throw exception
     * @param array $data
     */
    public function firstOrFail(array $data);

    /**it delete record from db according to the id you will pass
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**it delete record from db according to the filter you will pass
     * @param array $filters
     * @return bool
     */
    public function deleteWithFilter(array $filters): bool;

    /**it delete record from db according to the id you will pass
     * @param string $column
     * @param string $columnValue
     * @return bool
     */
    public function deleteWhere(string $column, string $columnValue): bool;


    /** it set authenticated current user id to use inside service and repository class
     * @param int $user_id
     * @return mixed
     */
    public function setAuthUserId(int $user_id);
}
