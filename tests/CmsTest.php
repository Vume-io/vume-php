<?php

namespace Vume\Tests;

use Vume\CMS;
use Vume\Exceptions\ConnectionException;
use Vume\Exceptions\AccessTokenInvalidException;

class CmsTest extends BaseTest
{
    public function testConstructCMS()
    {
        $this->assertInstanceOf(CMS::class, $this->vume);
    }

    public function testInvalidApiEndpoint()
    {
        $this->expectException(ConnectionException::class);

        $this->vume->setApiEndpoint('https://www.non-existing-vume-api.io');

        $section = $this->vume->section('section-test')->call();
    }

    public function testInvalidAccessToken()
    {
        $this->expectException(AccessTokenInvalidException::class);

        $this->vume->setAccessToken('non-existing-access-token');

        $this->vume->section('section-test')->call();
    }

    public function testCmsLanguageSetter()
    {
        $this->vume->setLanguage('en');

        $this->assertEquals('en', $this->vume->getLanguage());
    }
}
