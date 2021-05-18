<?php

namespace Modules\Todo\Repositories\Todo;

use Modules\Todo\Models\Todo;
use Modules\Core\Repositories\Base\BaseRepositoryInterface;

interface TodoRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param int $id
     * @return bool
     */
    public function checkOrUncheck(int $id): bool;

}
