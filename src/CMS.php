<?php

namespace Vume;

use Vume\Classes\Entry;
use Vume\Modules\ListModule;
use Vume\Modules\RelationModule;
use Vume\Modules\SectionModule;

class CMS
{
    private $api_endpoint = 'https://cms.vume.io';
    private $access_token;
    private $language;

    /**
     * Creates a new instance of the Vume cms
     *
     * @param string $access_token
     * @return CMS
     */
    public function __construct(string $access_token, string $api_endpoint = null)
    {
        $this->setAccessToken($access_token);

        if ($api_endpoint) {
            $this->setApiEndpoint($api_endpoint);
        }
    }

    /**
     * Set api endpoint
     *
     * @param string $api_endpoint
     * @return CMS
     */
    public function setApiEndpoint(string $api_endpoint)
    {
        $this->api_endpoint = $api_endpoint;

        return $this;
    }

    /**
     * Get api endpoint
     *
     * @return string $api_endpoint
     */
    public function getApiEndpoint()
    {
        return $this->api_endpoint;
    }

    /**
     * Set access token
     *
     * @param string $access_token
     * @return CMS
     */
    public function setAccessToken(string $access_token)
    {
        $this->access_token = $access_token;

        return $this;
    }

    /**
     * Get access token
     *
     * @return string $access_token
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * Set language
     *
     * @param string $language
     * @return CMS
     */
    public function setLanguage(string $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string $language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Return an instance of Vume\Modules\SectionModule
     *
     * @return Vume\Modules\SectionModule
     */
    public function section(string $slug)
    {
        return new SectionModule($slug, $this);
    }

    /**
     * Return an instance of Vume\Modules\ListModule
     *
     * @return Vume\Modules\ListModule
     */
    public function list(string $slug)
    {
        return new ListModule($slug, $this);
    }
}
