<?php

namespace Modules\Todo\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Controller\BaseApiController;
use Modules\Todo\DTO\Todo\TodoDTO;
use Modules\Todo\Services\Todo\TodoServiceInterface;

class TodoApiController extends BaseApiController
{
    public function __construct(TodoServiceInterface $service)
    {
        $this->service = $service;
        $this->dtoClass = TodoDTO::class;
    }

    public function store(Request $request)
    {
        $routeParameters = $request->route()->parameters;
        $parameters = $request->all();
        $dto = new $this->dtoClass();
        $validationResult = $dto->validate($parameters, false);
        if (!empty($validationResult) && count($validationResult) > 0) {
            return $this->notValidated($validationResult);
        }
        $parameters = $dto->toDto($parameters);
        $result = $this->willStore($parameters, $request, $routeParameters);
        return $this->created($result);
    }

    public function checkOrUncheck($todo_id) {
        $result = $this->service->checkOrUncheck($todo_id);
        return $this->ok($result);
    }
}
