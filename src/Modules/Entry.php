<?php

namespace Vume\Modules;

use Vume\Exceptions\EntryInvalidException;

class Entry
{
    public $id;
    private $fields;
    private $relations;

    /**
     * Constructor
     *
     * @param string $id
     * @param array $fields
     * @param array $relations
     */
    public function __construct(array $entry = [])
    {
        if (!isset($entry['fields']) || !isset($entry['relations'])) {
            throw new EntryInvalidException();
        }

        $this->id = $entry['id'] ?? null;
        $this->fields = $entry['fields'];
        $this->relations = new Relations($entry['relations']);
    }

    /**
     * Get the data field of entry
     *
     * @return string
     */
    public function field(string $slug)
    {
        return $this->fields[$slug]['data'] ?? null;
    }

    /**
     * Get the relations
     *
     * @return void
     */
    public function relations()
    {
        return $this->relations;
    }
}
