<?php

namespace Vume\Classes;

use ArrayAccess;
use Iterator;
use Vume\Traits\CollectionTrait;

class Fields implements ArrayAccess, Iterator
{
    use CollectionTrait;

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct(array $fields = [])
    {
        foreach ($fields as $field) {
            $this->add($field);
        }
    }
}
