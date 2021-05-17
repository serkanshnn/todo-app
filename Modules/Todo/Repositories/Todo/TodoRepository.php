<?php

namespace Modules\Todo\Repositories\Todo;

use Modules\Todo\Models\Todo;
use Modules\Core\Repositories\Base\BaseEloquentRepository;

class TodoRepository extends BaseEloquentRepository implements TodoRepositoryInterface
{
    /**
     * TodoRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Todo::class);
    }
}
