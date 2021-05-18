<?php

namespace Modules\Todo\Services\Todo;

use Modules\Todo\Models\Todo;
use Modules\Core\Services\Base\BaseServiceInterface;

/**
 * Interface TodoServiceInterface
 * @package Modules\Todo\Services\Todo\Todo
 */
interface TodoServiceInterface extends BaseServiceInterface
{
    /**
     * @param int $id
     * @return bool
     */
    public function checkOrUncheck(int $id): bool;
}
