<?php

namespace Vume\Classes;

use ArrayAccess;
use Iterator;
use Vume\Traits\CollectionTrait;

class Entries implements ArrayAccess, Iterator
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
