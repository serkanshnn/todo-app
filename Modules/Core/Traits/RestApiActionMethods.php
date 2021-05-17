<?php

namespace Modules\Core\Traits;

use Modules\Core\DTO\Base\BaseDTO;
use Modules\Core\Exception\NotImplementedException;
use Modules\Core\Services\Base\BaseServiceInterface;
use Illuminate\Http\Request;

/**
 * Class RestApiActionMethods.
 */
trait RestApiActionMethods
{
    /**
     * @var BaseServiceInterface
     */
    protected BaseServiceInterface $service;

    /**
     * @var string
     */
    protected string $dtoClass;

    /**
     * @var bool
     */
    protected bool $useCustomFilter = false;

    /**
     * @param Request $request
     * @return mixed
     * @throws NotImplementedException
     */
    public function index(Request $request)
    {
        $this->checkAuthMiddleware($request, function () use ($request) {
            $this->service->setAuthUserId($request->user()->id);
        });

        $this->checkIfDTOIsSet();

        if ($this->useCustomFilter) {
            return $this->ok($this->service->allWithFilter(['*'], 'id', 'asc', $request->route()->parameters));
        }
        return $this->ok($this->service->all());
    }

    /**
     * @param int $id
     * @param Request $request
     * @return mixed
     * @throws NotImplementedException
     */
    public function show(int $id, Request $request)
    {
        $this->checkAuthMiddleware($request, function () use ($request) {
            $this->service->setAuthUserId($request->user()->id);
        });
        $this->checkIfDTOIsSet();

        if ($this->useCustomFilter) {
            return $this->ok($this->service->findWithFilter($request->route()->parameters));
        }
        return $this->ok($this->service->find($id));
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws NotImplementedException
     */
    public function store(Request $request)
    {
        $auth_user_id = $request->user()->id;
        $this->checkAuthMiddleware($request, function () use ($auth_user_id, $request) {
            $this->service->setAuthUserId($auth_user_id);
        });
        $this->checkIfDTOIsSet();

        $routeParameters = $request->route()->parameters;
        $parameters = $request->all();
        $dto = new $this->dtoClass();
        if ($this->useCustomFilter) {
            $dto->handleRequestParameters($parameters, $routeParameters, $auth_user_id);
        }
        $validationResult = $dto->validate($parameters, false);
        if (!empty($validationResult) && count($validationResult) > 0) {
            return $this->notValidated($validationResult);
        }
        $parameters = $dto->toDto($parameters);
        $result = $this->willStore($parameters, $request, $routeParameters);
        return $this->created($result);
    }

    /**it triggers before model->create method
     * @param BaseDTO $DTO
     * @param Request $request
     * @param array $routeParameters
     * @return BaseDTO
     */
    public function willStore(BaseDTO $DTO, Request $request, array $routeParameters)
    {
        if ($this->useCustomFilter == true) {
            return $this->service->createWithFilters($routeParameters, $DTO);
        }
        return $this->service->create($DTO);
    }

    /**it triggers after model->create method
     * @param $model
     */
    public function didStore($model)
    {

    }

    /**
     * @param int $id
     * @param Request $request
     * @return mixed
     * @throws NotImplementedException
     */
    public function update(int $id, Request $request)
    {
        $auth_user_id = $request->user()->id;
        $this->checkAuthMiddleware($request, function () use ($auth_user_id, $request) {
            $this->service->setAuthUserId($auth_user_id);
        });

        $this->checkIfDTOIsSet();
        $parameters = $request->all();
        $dto = new $this->dtoClass();
        if ($this->useCustomFilter) {
            $dto->handleRequestParameters($parameters, $request->route()->parameters, $auth_user_id);
        }
        $validationResult = $dto->validate($parameters, true);
        if (!empty($validationResult) && count($validationResult) > 0) {
            return $this->notValidated($validationResult);
        }

        $dtoInstance = ($dto->toDto($parameters, false));
        if ($this->useCustomFilter) {
            $result = $this->service->updateWithFilter($request->route()->parameters, $dtoInstance);
        } else {
            $result = $this->service->update($id, $dtoInstance);
        }

        return $this->updated($result);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return mixed
     * @throws NotImplementedException
     */
    public function destroy(int $id, Request $request)
    {
        $this->checkAuthMiddleware($request, function () use ($request) {
            $this->service->setAuthUserId($request->user()->id);
        });

        $this->checkIfDTOIsSet();

        if ($this->useCustomFilter) {
            $result = $this->service->deleteWithFilter($request->route()->parameters);
        } else {
            $result = $this->service->delete($id);
        }

        return $this->deleted($result);
    }

    /**
     * @throws NotImplementedException
     */
    private function checkIfDTOIsSet()
    {
        if (empty($this->dtoClass)) {
            throw new NotImplementedException('Please specify dto class type in your controller constructor.');
        }
    }

    /**
     * @param Request $request
     * @param $callback
     */
    private function checkAuthMiddleware(Request $request, $callback)
    {
        $result = $request->route()->middleware();
        if (in_array('auth:api', $result)) {
            $callback();
        }
    }
}
