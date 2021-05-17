<?php

namespace Modules\Core\Services\Base;

use Modules\Core\DTO\Base\BaseDTO;
use Illuminate\Support\Collection;

interface BaseServiceInterface
{
    /** it does create a record according to the array you will pass.
     * @param BaseDTO $dto
     * @return BaseDTO
     */
    public function create(BaseDTO $dto): BaseDTO;

    /** it does create a record according to the array you will pass.
     * @param array $filters
     * @param BaseDTO $dto
     * @return BaseDTO
     */
    public function createWithFilters(array $filters, BaseDTO $dto): BaseDTO;

    /** it does update according to the array you will pass.
     * @param int $id
     * @param BaseDTO $dto
     * @return bool
     */
    public function update(int $id, BaseDTO $dto): bool;

    /** it does update according to the array you will pass.
     * @param array $filters
     * @param BaseDTO $dto
     * @return bool
     */
    public function updateWithFilter(array $filters, BaseDTO $dto): bool;

    /** it fetch all data from database.
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return Collection
     */
    public function all($columns = ['*'], string $orderBy = 'id', string $sortBy = 'asc'): array;

    /** it fetch all data from database.
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @param array $filters
     * @return Collection
     */
    public function allWithFilter($columns, string $orderBy, string $sortBy, array $filters): array;

    /** it find just one record from db according to the id you will pass.
     * @param $id
     * @return BaseDTO|null
     */
    public function find($id): ?BaseDTO;

    /** it find just one record from db according to the id you will pass.
     * @param $filters
     * @return BaseDTO
     */
    public function findWithFilter(array $filters): BaseDTO;

    /**it find just one record from db according to the id you will pass
     * if it is doesn't fetch it will be throw exception
     * @param $id
     */
    public function findOrFail($id);

    /**it fetch records from db according to the conditions you will pass
     * @param array $data
     */
    public function findBy(array $data);

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

    /**it delete record from db according to the id you will pass
     * @param int $id
     * @return bool
     */
    public function deleteWithFilter(array $filters): bool;

    /** it set authenticated current user id to use inside service and repository class
     * @param int $user_id
     * @return mixed
     */
    public function setAuthUserId(int $user_id);
}
