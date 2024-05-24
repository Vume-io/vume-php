<?php

namespace Vume\Tests;

class FileTest extends BaseTest
{

    public function testSingleFileFromSection()
    {
        $section = $this->vume->section('section-test')->entry();

        $file = $section->field('file')->value('url');

        $this->assertNotNull($file);

        $this->assertEquals($file, $section->file('file'));
        $this->assertEquals($file, $section->file('file', 'url'));
        $this->assertEquals($file, $section('file'));
    }
}
