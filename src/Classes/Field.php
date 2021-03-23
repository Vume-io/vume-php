<?php

namespace Vume\Classes;

use Vume\Exceptions\EntryInvalidException;
use Vume\Modules\Module;
use Vume\Modules\RelationModule;
use Vume\Classes\Relations;
use Vume\Exceptions\FieldInvalidException;

class Field
{
    public $id;
    public $type;
    public $data;
    public $custom_value;

    /**
     * Constructor
     *
     * @param array $field
     */
    public function __construct(array $field)
    {
        if (!isset($field['id']) || !isset($field['type'])) {
            throw new FieldInvalidException();
        }

        $this->id = $field['id'];
        $this->type = $field['type'];
        $this->data = $field['data'] ?? null;
        $this->value = $this->value();
    }

    public function value($key = null)
    {
        if ($this->custom_value) {
            return $key ? ($this->value[$key] ?? null) : $this->value;
        }

        switch ($this->type) {
            case 'image':
                $value = $this->data ?? null;
                return $key ? ($value[0][$key] ?? null) : $value;
            default:
                return $this->data;
        }
    }

    public function versions()
    {
        $this->custom_value = true;
        if ($this->type !== 'image') {
            return;
        }

        $this->value = array_filter(array_map(fn ($data) => $data['versions'] ?? null, $this->data)) ?? [];
        return $this;
    }

    public function version(string $version)
    {
        $this->custom_value = true;
        if ($this->type !== 'image') {
            return;
        }

        $this->versions();
        $version = array_filter(array_map(fn ($version_data) => $version_data[$version] ?? null, $this->value)) ?? [];
        $this->value = $version[0] ?? [];
        return $this;
    }
}
