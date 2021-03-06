<?php

namespace Vume\Classes;

use ArrayAccess;
use Iterator;
use Vume\Traits\CollectionTrait;

class Relations implements ArrayAccess, Iterator
{
    use CollectionTrait;

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct(array $relations = [])
    {
        foreach ($relations as $relation) {
            $this->add($relation);
        }
    }
}
