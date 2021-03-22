<?php

namespace Vume\Exceptions;

use Exception;

class EntryInvalidException extends Exception
{
    public function __construct()
    {
        parent::__construct('Entry invalid');
    }
}
