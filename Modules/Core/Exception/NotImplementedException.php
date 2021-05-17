<?php

namespace Modules\Core\Exception;

use Exception;

class NotImplementedException extends Exception
{
    /**
     * NotImplementedException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }
}
