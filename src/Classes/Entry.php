<?php

namespace Vume\Classes;

use Vume\Exceptions\EntryInvalidException;
use Vume\Modules\Module;
use Vume\Modules\RelationModule;
use Vume\Classes\Relations;

class Entry
{
    public $id;
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
     * Invoke
     *
     * @param array $arguments
     */
    public function __invoke(...$arguments)
    {
        if(!$arguments) {
            return;
        }

        if(!$field = $this->field($arguments[0])) {
            return;
        }

        if(!$field->hasImages()) {
            return $field->value($arguments[1] ?? null);
        }

        $version = $arguments[1] ?? null;
        $value = $arguments[2] ?? null;

        return $version ? $field->version($version)->value($value) : $field->value($value);
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
     * Get the relation of an entry
     *
     * @param string $slug
     *
     * @return null|RelationModule $relation
     */
    public function relation(string $slug)
    {
        return $this->relations->find($slug) ?? null;
    }

    /**
     * Get the data field of entry
     *
     * @return null|Fields $fields
     */
    public function fields()
    {
        return $this->fields ?? new Fields();
    }

    /**
     * Get the data field of entry
     *
     * @param string $slug
     *
     * @return null|Field $field
     */
    public function field(string $slug)
    {
        return $this->fields->find($slug) ?? null;
    }

    /**
     * Get the entry field value by slug
     *
     * @param string $slug
     *
     * @return mixed $value
     */
    public function value(string $slug, string $key = null)
    {
        if (!$field = $this->field($slug)) {
            return null;
        }

        return $field->value($key);
    }

    /**
     * Get the entry image url by field slug and optional version
     *
     * @param string $slug
     * @param string|null $version
     * @param string|null $key
     *
     * @return mixed $image
     */
    public function image(string $slug, string $version = null, string $key = null)
    {
        if (!$field = $this->field($slug)) {
            return null;
        }

        if(!$field->hasImages()) {
            return null;
        }

        if(!$version) {
            return $field->value($key);
        }

        return $field->version($version)->value($key);
    }

     /**
     * Get the entry file url by field slug
     *
     * @param string $slug
     * @param string|null $key
     *
     * @return mixed $file
     */
    public function file(string $slug, string $key = null)
    {
        if (!$field = $this->field($slug)) {
            return null;
        }

        if(!$field->hasFiles()) {
            return null;
        }

        return $field->value($key);
    }

    public function isCached()
    {
        return $this->module->isCached();
    }
}
