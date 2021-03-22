<?php

namespace Vume\Modules;

use ArrayAccess;

class Relations implements ArrayAccess
{
    protected $relations;

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

    /**
     * Set offset
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->relations[] = $value;
        } else {
            $this->relations[$offset] = $value;
        }
    }

    /**
     * Check if offset exists
     *
     * @return bool $exists
     */
    public function offsetExists($offset)
    {
        return isset($this->relations[$offset]);
    }

    /**
     * Unset offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->relations[$offset]);
    }

    /**
     * Get offset
     *
     * @return int $offset
     */
    public function offsetGet($offset)
    {
        return $this->relations[$offset] ?? null;
    }

    /**
     * Add relation
     *
     * @return self
     */
    public function add(array $relation)
    {
        $this->relations[] = new RelationModule($relation);

        return $this;
    }
}
