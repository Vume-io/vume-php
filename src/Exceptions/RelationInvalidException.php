<?php

namespace Vume\Exceptions;

use Exception;

class RelationInvalidException extends Exception
{
    public function __construct()
    {
        parent::__construct('Relation invalid');
    }
}
