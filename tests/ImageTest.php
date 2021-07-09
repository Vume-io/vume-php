<?php

namespace Vume\Tests;

use Vume\Classes\Entry;
use Vume\Classes\Relations;
use Vume\Modules\SectionModule;
use Vume\Exceptions\SectionNotFoundException;
use Vume\Modules\RelationModule;

class ImageTest extends BaseTest
{

    public function testSingleImageFromSection()
    {
        $section = $this->vume->section('section-test')->entry();

        $this->assertNotNull($section->field('image')->value('url'));
        $this->assertNotNull($section->field('image')->version('thumbnail')->value('url'));
    }

    public function testAlbumFromSection()
    {
        $section = $this->vume->section('section-test')->entry();

        $this->assertNotNull($section->field('album')->value('url'));
        $this->assertNotNull($section->field('album')->version('thumbnail')->value('url'));

        foreach ($section->field('album')->images() as $image) {
            $this->assertNotNull($image->value('url'));
            $this->assertNotNull($image->version('thumbnail')->value('url'));
        }
    }

}
