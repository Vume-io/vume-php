<?php

namespace Vume\Traits;

trait CollectionTrait
{
    protected $collection;
    protected $index = 0;

    /**
     * Set offset
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->collection[] = $value;
        } else {
            $this->collection[$offset] = $value;
        }
    }

    /**
     * Check if offset exists
     *
     * @return bool $exists
     */
    public function offsetExists($offset)
    {
        return isset($this->collection[$offset]);
    }

    /**
     * Unset offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->collection[$offset]);
    }

    /**
     * Get offset
     *
     * @return int $offset
     */
    public function offsetGet($offset)
    {
        return $this->collection[$offset] ?? null;
    }

    /**
     * Current item
     *
     * @return mixed
     */
    public function current()
    {
        return $this->collection[$this->index];
    }

    /**
     * Next item
     *
     * @return void
     */
    public function next()
    {
        $this->index++;
    }

    /**
     * Rewind index
     *
     * @return void
     */
    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * Get the key
     *
     * @return scalar
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * Check if collection item on key is valid
     *
     * @return bool
     */
    public function valid()
    {
        return isset($this->collection[$this->key()]);
    }

    /**
     * Add entry
     *
     * @return self
     */
    public function add($item)
    {
        $this->collection[] = $item;

        return $this;
    }

    /**
     * Get first record of collection
     *
     * @return Vume\Modules\Entry $item
     */
    public function first()
    {
        return $this->collection[0] ?? null;
    }

    /**
     * Get last record of collection
     *
     * @return Vume\Modules\Entry $item
     */
    public function last()
    {
        return end($this->collection) ?? null;
    }

    /**
     * Find entry by id
     *
     * @param string $id
     * @return Vume\Modules\Entry $item
     */
    public function find($id)
    {
        foreach ($this->collection as $item) {
            if ($item->id === $id) return $item;
        }

        return null;
    }

    /**
     * Count collection
     *
     * @return int $count
     */
    public function count()
    {
        return count($this->collection);
    }
}
