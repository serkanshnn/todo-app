<?php

namespace Modules\Todo\Services\Todo;

use Modules\Todo\DTO\Todo\TodoDTO;
use Modules\Todo\Repositories\Todo\TodoRepositoryInterface;
use Modules\Todo\Services\Todo\TodoServiceInterface;
use Modules\Core\Services\Base\BaseService;

class TodoService extends BaseService implements TodoServiceInterface
{
    /**
     * @var TodoRepositoryInterface
     */
    private TodoRepositoryInterface $repository;


    /**
     * TodoService constructor.
     * @param TodoRepositoryInterface $repository
     */
    public function __construct(TodoRepositoryInterface $repository)
    {
        parent::__construct($repository, TodoDTO::class);
        $this->repository = $repository;
    }
}
