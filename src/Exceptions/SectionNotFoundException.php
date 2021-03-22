<?php

namespace Vume\Exceptions;

use Exception;

class SectionNotFoundException extends Exception
{
   public function __construct()
   {
      parent::__construct('Section not found');
   }
}
