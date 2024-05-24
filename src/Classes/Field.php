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
    public $images;
    public $files;

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

        if ($this->type === 'image') {
            foreach($this->data as $image) {
                $this->images[] = new Image($image);
            }
        }

        if ($this->type === 'file') {
            foreach($this->data as $file) {
                $this->files[] = new File($file);
            }
        }
    }

    public function value($key = null)
    {
        switch ($this->type) {
            case 'image':
                return $this->images ? $this->images[0]->value($key) : null;
            case 'file':
                return $this->files ? $this->files[0]->value($key) : null;
            default:
                return $this->data;
        }
    }

    public function versions()
    {
        if (!$this->images) {
            return;
        }

        return $this->images[0]->versions();
    }

    public function version(string $version)
    {
        if (!$this->images) {
            return;
        }

        return $this->images[0]->version($version);
    }

    public function images()
    {
        if ($this->type !== 'image') {
            return;
        }

        return $this->images;
    }

    public function hasImages()
    {
        return $this->images ? true : false;
    }

    public function hasFiles()
    {
        return $this->files ? true : false;
    }
}
