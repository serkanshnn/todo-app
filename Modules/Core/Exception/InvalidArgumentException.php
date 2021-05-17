<?php

namespace Modules\Core\Exception;

use Exception;

class InvalidArgumentException extends Exception
{
    /**
     * InvalidArgumentException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }
}
