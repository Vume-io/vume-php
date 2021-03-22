<?php

namespace Vume\Exceptions;

use Exception;

class RelationNotFoundException extends Exception
{
   public function __construct()
   {
      parent::__construct('Relation not found');
   }
}
