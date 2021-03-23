<?php

namespace Vume\Classes;

use Vume\Exceptions\EntryInvalidException;
use Vume\Modules\Module;
use Vume\Modules\RelationModule;
use Vume\Classes\Relations;

class Entry
{
    protected $id;
    private $fields;
    protected $module;
    protected $relations = [];

    /**
     * Constructor
     *
     * @param array $entry
     * @param Vume\CMS $cms
     */
    public function __construct(array $entry, Module $module)
    {
        if (!isset($entry['fields']) || !isset($entry['relations'])) {
            throw new EntryInvalidException();
        }

        $this->id = $entry['id'] ?? null;
        $this->module = $module;
        $this->fields = new Fields();
        $this->relations = new Relations();

        foreach ($entry['fields'] as $slug => $field) {
            $this->fields->add(new Field(array_merge($field, ['id' => $slug])));
        }

        foreach ($entry['relations'] as $relation) {
            $this->relations->add(new RelationModule($relation, $this));
        }
    }

    /**
     * Get the id of the entry
     *
     * @return string $id
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Get the relations of the entry
     *
     * @return Relations $relations
     */
    public function relations()
    {
        return $this->relations;
    }

    /**
     * Get the parent module of the entry
     *
     * @return Module $module
     */
    public function module()
    {
        return $this->module;
    }

    /**
     * Get the data field of entry
     *
     * @return string
     */
    public function field(string $slug)
    {
        return $this->fields->find($slug) ?? null;
    }
}
