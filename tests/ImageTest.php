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

        $image = $section->field('image')->value('url');
        $thumbnail = $section->field('image')->version('thumbnail')->value('url');

        $this->assertNotNull($image);
        $this->assertNotNull($thumbnail);

        $this->assertEquals($image, $section->image('image'));
        $this->assertEquals($image, $section->image('image', null, 'url'));
        $this->assertEquals($thumbnail, $section->image('image', 'thumbnail', 'url'));
        $this->assertEquals($image, $section('image'));
        $this->assertEquals($thumbnail, $section('image', 'thumbnail'));
    }

    public function testAlbumFromSection()
    {
        $section = $this->vume->section('section-test')->entry();

        $this->assertNotNull($section->field('gallery')->value('url'));
        $this->assertNotNull($section->field('gallery')->version('thumbnail')->value('url'));

        foreach ($section->field('gallery')->images() as $image) {
            $this->assertNotNull($image->value('url'));
            $this->assertNotNull($image->version('thumbnail')->value('url'));
        }
    }

}
