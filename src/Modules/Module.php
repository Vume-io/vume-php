<?php

namespace Vume\Modules;

use Vume\CMS;
use Vume\Libraries\Api;
use Vume\Exceptions\SectionNotFoundException;
use Vume\Exceptions\ListNotFoundException;
use Vume\Exceptions\RelationNotFoundException;

class Module
{
    protected $cms;
    protected $api;
    protected $name;
    protected $route;
    protected $called = false;
    protected $builder = [];

    /**
     * Construct class
     *
     * @param Vume\CMS $cms
     */
    public function __construct(CMS $cms)
    {
        $this->cms = $cms;
        $this->api = new Api($cms->getApiEndpoint(), $cms->getAccessToken());
    }

    /**
     * Call API
     *
     * @return array $data
     */
    public function call()
    {
        $this->called = true;
        $result = $this->api->call('GET', $this->route, $this->builder);

        switch ($result['code']) {
            case 200:
                $this->name = $result['body']['data']['name'] ?? null;
                return $result['body']['data'] ?? [];
            default:
                switch (get_class($this)) {
                    case 'Vume\Modules\SectionModule':
                        throw new SectionNotFoundException();
                    case 'Vume\Modules\ListModule':
                        throw new ListNotFoundException();
                    case 'Vume\Modules\RelationModule':
                        throw new RelationNotFoundException();
                }
        }
    }

    /**
     * Get the name of the loaded module
     *
     * @return string $name
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Add to builder
     * 
     * @return void
     */
    protected function addToBuilder($key, $value)
    {
        $this->builder[$key] = $value;

        return $this;
    }

    /**
     * Add where clause to builder
     * 
     * @param string $field
     * @param string $value
     * @return self
     */
    protected function addWhereClauseToBuilder($field, $value)
    {
        if (!isset($this->builder['where'])) $this->builder['where'] = [];

        $this->builder['where'][$field] = $value;

        return $this;
    }

    /**
     * Add search clause to builder
     * 
     * @param string $field
     * @param string $value
     * @return self
     */
    protected function addSearchClauseToBuilder($field, $value)
    {
        if (!isset($this->builder['search'])) $this->builder['search'] = [];

        $this->builder['search'][$field] = $value;

        return $this;
    }
}
