<?php

namespace Vume\Modules;

use ArrayAccess;

class Entries implements ArrayAccess
{
    protected $entries;

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

    /**
     * Set offset
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->entries[] = $value;
        } else {
            $this->entries[$offset] = $value;
        }
    }

    /**
     * Check if offset exists
     *
     * @return bool $exists
     */
    public function offsetExists($offset)
    {
        return isset($this->entries[$offset]);
    }

    /**
     * Unset offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->entries[$offset]);
    }

    /**
     * Get offset
     *
     * @return int $offset
     */
    public function offsetGet($offset)
    {
        return $this->entries[$offset] ?? null;
    }

    /**
     * Add entry
     *
     * @return self
     */
    public function add(array $entry)
    {
        $this->entries[] = new Entry($entry);

        return $this;
    }

    /**
     * Get first record of entries
     *
     * @return Vume\Modules\Entry $entry
     */
    public function first()
    {
        return $this->entries[0] ?? null;
    }

    /**
     * Get last record of entries
     *
     * @return Vume\Modules\Entry $entry
     */
    public function last()
    {
        return end($this->entries) ?? null;
    }

    /**
     * Find entry by id
     *
     * @param string $id
     * @return Vume\Modules\Entry $entry
     */
    public function find($id)
    {
        foreach ($this->entries as $entry) {
            if ($entry->id === $id) return $entry;
        }

        return null;
    }

    /**
     * Count entries
     *
     * @return int $count
     */
    public function count()
    {
        return count($this->entries);
    }
}
