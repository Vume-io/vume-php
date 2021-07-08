<?php

namespace Vume\Libraries;

use Flintstone\Flintstone as Cache;

class Caching
{
    private $cache;

    /**
     * Construct
     */
    public function __construct(string $dir)
    {
        $this->cache = new Cache('vume', ['dir' => $dir]);
    }

    /**
     * Set
     * 
     * @param string $route
     * @param array $builder
     * @param array $data
     * 
     * @return void
     */
    public function set(string $route, array $builder, array $data)
    {
        $data['cached'] = time();

        $this->cache->set($this->constructKey($route, $builder), $data);
    }

    /**
     * Get
     * 
     * @param string $route
     * @param array $builder
     * 
     * @return $data|false
     */
    public function get(string $route, array $builder)
    {
        return $this->cache->get($this->constructKey($route, $builder));
    }

    /**
     * Clear cache
     * 
     * @return void
     */
    public function clear()
    {
        $this->cache->flush();
    }

    /**
     * Construct key
     * 
     * @param string $route
     * @param array $builder
     * 
     * @return string $key
     */
    private function constructKey(string $route, array $builder)
    {
        ksort($builder);
        return md5($route . serialize($builder));
    }

}