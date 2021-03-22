<?php

namespace Vume\Classes;

use ArrayAccess;
use Vume\Traits\CollectionTrait;

class Entries implements ArrayAccess
{
    use CollectionTrait;

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct(array $entries = [])
    {
        foreach ($entries as $entry) {
            $this->add($entry);
        }
    }
}
