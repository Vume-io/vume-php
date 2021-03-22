<?php

namespace Vume\Modules;

use Vume\CMS;

class SectionModule extends Module
{
    protected $entry;

    /**
     * Constructor
     *
     * @param string $section
     * @param Vume\CMS $cms
     */
    public function __construct(string $section, CMS $cms)
    {
        $this->route = '/section';
        $this->addToBuilder('section', $section);

        parent::__construct($cms);
    }

    /**
     * Call
     * 
     * @return Self
     */
    public function call()
    {
        $data = parent::call();

        $this->entry = new Entry($data['entry']);

        return $this;
    }

    /**
     * Return entry
     *
     * @return Vume\Modules\Entry $entry
     */
    public function entry()
    {
        if (!$this->called) {
            $this->call();
        }

        return $this->entry;
    }
}
