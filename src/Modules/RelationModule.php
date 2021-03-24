<?php

namespace Vume\Modules;

use Vume\Classes\Entries;
use Vume\Classes\Entry;
use Vume\CMS;
use Vume\Exceptions\RelationInvalidException;
use Vume\Traits\EntriesTrait;

class RelationModule extends Module
{
    use EntriesTrait;

    public $id;
    protected $entries;
    protected $entry;

    /**
     * Constructor
     *
     * @param array $relation
     * @param Vume\CMS $cms
     */
    public function __construct(array $relation, Entry $entry)
    {
        parent::__construct($entry->module()->cms());

        if (!isset($relation['name']) || !isset($relation['slug']) || !isset($relation['entries_total'])) {
            throw new RelationInvalidException();
        }

        $this->id = $relation['slug'];
        $this->entries = new Entries();
        $this->entry = $entry;

        $this->route = '/relation';
        $this->addToBuilder('relation', $relation['slug']);
        $this->addToBuilder('module_type', $entry->module()->type());
        $this->addToBuilder('target_entry_id', $entry->id());
    }
}
