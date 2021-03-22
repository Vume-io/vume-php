<?php

namespace Vume\Modules;

use Vume\CMS;
use Vume\Traits\EntriesTrait;

class ListModule extends Module
{
    use EntriesTrait;

    protected $entries;

    /**
     * Constructor
     *
     * @param string $list
     * @param Vume\CMS $cms
     */
    public function __construct(string $list, CMS $cms)
    {
        $this->route = '/list';
        $this->addToBuilder('list', $list);

        $this->entries = new Entries();

        parent::__construct($cms);
    }
}
