<?php

namespace Modules\Core\Exception;

use Exception;

class NotFoundException extends Exception
{
    /**
     * NotFoundException constructor.
     * @param string $objectName
     */
    public function __construct(string $objectName)
    {
        $this->message = "Specified {$objectName} was not found.";
    }
}
