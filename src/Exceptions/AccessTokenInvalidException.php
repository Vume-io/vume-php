<?php

namespace Vume\Exceptions;

use Exception;

class AccessTokenInvalidException extends Exception
{
    public function __construct()
    {
        parent::__construct('Access token invalid');
    }
}
