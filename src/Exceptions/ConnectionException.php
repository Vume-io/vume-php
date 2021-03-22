<?php

namespace Vume\Exceptions;

use Exception;

class ConnectionException extends Exception
{
    public function __construct()
    {
        parent::__construct('Connection failed');
    }
}
