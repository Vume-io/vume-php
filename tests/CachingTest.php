<?php

namespace Vume\Tests;

use Vume\CMS;
use Vume\Exceptions\ConnectionException;
use Vume\Exceptions\AccessTokenInvalidException;

class CachingTest extends BaseTest
{
    public function testSetCachingState()
    {
        $this->vume->setCaching(true);
        
        $this->assertTrue($this->vume->getCaching());
    }

    public function testCachingSection()
    {
        $this->vume->setCaching(true, '.')->clearCache();

        $entry = $this->vume->section('section-test')->entry();
        $this->assertFalse($entry->isCached());

        $entry = $this->vume->section('section-test')->entry();
        $this->assertTrue($entry->isCached());
    }
}
