<?php

namespace Modules\Todo\Http\Controllers\Api;

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
}
