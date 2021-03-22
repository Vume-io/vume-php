<?php

namespace Vume\Modules;

class RelationModule extends Module
{
    protected $name;
    protected $slug;
    protected $entries;
    protected $entries_total;

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct(array $relation = [])
    {
        if (!isset($relation['name']) || !isset($relation['slug']) || !isset($relation['entries_total'])) {
            throw new RelationInvalidException();
        }

        $this->name = $relation['name'];
        $this->slug = $relation['slug'];

        $this->entries = new Entries();
        $this->entries_total = $relation['entries_total'];
    }
}
