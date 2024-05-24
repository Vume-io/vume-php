<?php

namespace Vume\Classes;


class File
{
    public $url;

    /**
     * Constructor
     *
     * @param array $file
     */
    public function __construct(array $file)
    {
        $this->url = $file['url'];
    }

    public function value($key = null)
    {
        return $this->$key ?? (!$key ? $this->url : null);
    }
}