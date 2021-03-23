<?php

namespace Vume\Exceptions;

use Exception;

class FieldInvalidException extends Exception
{
    public function __construct()
    {
        parent::__construct('Field invalid');
    }
}
