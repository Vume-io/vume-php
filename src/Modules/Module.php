<?php

namespace Vume\Modules;

use Vume\CMS;
use Vume\Libraries\Api;
use Vume\Libraries\Caching;
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
    protected $cached = false;

    /**
     * Construct class
     *
     * @param Vume\CMS $cms
     */
    public function __construct(CMS $cms)
    {
        $this->cms = $cms;
        $this->api = new Api($cms->getApiEndpoint(), $cms->getAccessToken());
        $this->caching = new Caching($this->cms->getCachingDir());

        if ($this->cms->getLanguage()) {
            $this->language($this->cms->getLanguage());
        }
    }

    /**
     * Call API
     *
     * @return array $data
     */
    public function call()
    {
        $this->called = true;
        
        $result = $this->getCache($this->route, $this->builder) ?: $this->api->call('GET', $this->route, $this->builder);
  
        switch ($result['code']) {
            case 200:
                $data = $result['body']['data'] ?? [];

                $this->name = $data['name'] ?? null;
                $this->cached = !empty($result['cached']);

                if(!$this->cached) {
                    $this->setCache($this->route, $this->builder, $result);
                }

                return $data;
            default:
                switch ($this->type()) {
                    case 'section':
                        throw new SectionNotFoundException();
                    case 'list':
                        throw new ListNotFoundException();
                    case 'relation':
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
     * Get the type of the loaded module
     *
     * @return string $name
     */
    public function type()
    {
        $type = get_class($this);

        switch ($type) {
            case 'Vume\Modules\SectionModule':
                return 'section';
            case 'Vume\Modules\ListModule':
                return 'list';
            case 'Vume\Modules\RelationModule':
                return 'relation';
        }

        return $type;
    }

    /**
     * Get the cms of the loaded module
     *
     * @return Cms $cms
     */
    protected function cms()
    {
        return $this->cms;
    }

    /**
     * Add language to builder
     *
     * @param string $language
     * @return void
     */
    public function language(string $language)
    {
        $this->addToBuilder('language', $language);

        return $this;
    }

    /**
     * Is cached
     * 
     * @return boolean $cached
     */
    public function isCached()
    {
        return $this->cached;
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

    /**
     * Cache result
     * 
     * @param string $route
     * @param array $builder
     * @param array $data
     * 
     * @return void
     */
    protected function setCache(string $route, array $builder, array $data)
    {
        if(!$this->cms->getCaching()) return;

        $this->caching->set($this->route, $this->builder, $data);
    }
    
    /**
     * Get Cache
     * 
     * @param string $route
     * @param array $builder
     * 
     * @return array $data
     */
    protected function getCache(string $route, array $builder)
    {
        if(!$this->cms->getCaching()) return;

        return $this->caching->get($this->route, $this->builder);
    }
   
}
