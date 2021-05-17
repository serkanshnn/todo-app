<?php

namespace Modules\Core\DTO\Base;

use Illuminate\Support\Collection;

/**
 * Interface BaseDTOInterface.
 */
interface BaseDTOInterface
{
    /**It converts DTO to Eloquent Model
     * @return mixed
     */
    public function toModel();

    /**It converts Eloquent Model to DTO
     * @param array $parameters
     * @param bool $allParametersAreRequired If you set true, it will be checking every property in your DTO. After that, you should specify the value for each of
     * @return self
     */
    public function toDTO(array $parameters = [], bool $allParametersAreRequired = true): self;

    /**It converts collection items to DTO list
     * @param Collection $collection
     * @param $type
     * @return BaseDTO[]
     */
    public function toList(Collection $collection, $type);

    /**It converts Eloquent Model to DTO
     * @param $dto
     * @param array $originalData
     * @return $this
     */
    public function mapToDTO($dto, array $originalData): self;

    /**It validates your passed parameters
     * @param array $parameters
     * @param array $rules
     * @return mixed
     */
    public function validator(array $parameters, array $rules);

    /**It validates your passed parameters
     * @param array $parameters
     * @param bool $updateMode
     * @return mixed
     */
    public function validate(array $parameters, bool $updateMode);

    /**it gets request query string parameters and route parameters.
     * You can manipulate as you need
     * @param array $requestParameters
     * @param array $routeParameters
     * @param int $auth_user_id
     * @return $this
     */
    public function handleRequestParameters(array $requestParameters, array $routeParameters, int $auth_user_id): self;
}
