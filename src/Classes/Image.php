<?php

namespace Vume\Classes;


class Image
{
    public $width;
    public $height;
    public $url;
    public $alt;
    public $versions;

    /**
     * Constructor
     *
     * @param array $image
     */
    public function __construct(array $image)
    {
        $this->width = $image['width'];
        $this->height = $image['height'];
        $this->url = $image['url'];
        $this->alt = $image['alt'];

        if(!empty($image['versions'])) {
            foreach ($image['versions'] as $key => $version) {
                $this->versions[$key] = new static($version);   
            } 
        }
    }

    public function versions()
    {
        if(!$this->versions) {
            return;
        }

        return $this->versions;
    }

    public function version(string $version)
    {
        return $this->versions[$version] ?? null;
    }

    public function value($key = null)
    {
        return $this->$key ?? (!$key ? $this->url : null);
    }



}