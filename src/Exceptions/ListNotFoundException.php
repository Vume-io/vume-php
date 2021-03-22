<?php

namespace Vume\Exceptions;

use Exception;

class ListNotFoundException extends Exception
{
   public function __construct()
   {
      parent::__construct('List not found');
   }
}
