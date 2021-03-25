<?php

namespace Vume\Traits;

use Vume\Classes\Entry;
use Vume\Modules\EntryModule;

trait EntriesTrait
{
    protected $entries_total;

    /**
     * Where clause
     *
     * @param string $field
     * @param string $value
     * @return self
     */
    public function where($field, $value)
    {
        return $this->addWhereClauseToBuilder($field, $value);
    }

    /**
     * Search clause
     *
     * @param string $field
     * @param string $value
     * @return self
     */
    public function search($field, $value)
    {
        return $this->addSearchClauseToBuilder($field, $value);
    }

    /**
     * Limit
     *
     * @param int $value
     * @return self
     */
    public function limit(int $value)
    {
        return $this->addToBuilder('limit', abs($value));
    }

    /**
     * Offset
     *
     * @param int $value
     * @return self
     */
    public function offset(int $value)
    {
        return $this->addToBuilder('offset', abs($value));
    }

    /**
     * Call
     *
     * @return self
     */
    public function call()
    {
        $data = parent::call();

        $this->entries_total = $data['entries_total'];
        $this->addEntries($data['entries']);

        return $this;
    }

    /**
     * Add entries
     *
     * @param array $entries
     * @return void
     */
    private function addEntries(array $entries = [])
    {
        foreach ($entries as $entry) {
            $this->entries->add(new Entry($entry, $this));
        }
    }

    /**
     * Return entries
     *
     * @return Vume\Classes\Entries $entries
     */
    public function entries()
    {
        if (!$this->called) {
            $this->call();
        }

        return $this->entries;
    }

    /**
     * Find entry by id
     *
     * @param string $id
     * @return Vume\Classes\Entry $entry
     */
    public function find($id)
    {
        return $this->where('id', $id)->limit(1)->entries()->first();
    }

    /**
     * First entry
     *
     * @return Vume\Classes\Entry $entry
     */
    public function first()
    {
        return $this->limit(1)->entries()->first();
    }
}
