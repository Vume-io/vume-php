<?php

namespace Vume\Tests;

use Vume\Modules\Entry;
use Vume\Modules\Relations;
use Vume\Modules\SectionModule;
use Vume\Exceptions\SectionNotFoundException;

class SectionTest extends BaseTest
{
    public function testSectionInstance()
    {
        $section = $this->vume->section('section-test', true);

        $this->assertInstanceOf(SectionModule::class, $section);
    }

    public function testSectionNotFoundException()
    {
        $this->expectException(SectionNotFoundException::class);

        $this->vume->section('non-existing-section')->call();
    }

    public function testEntryFromSection()
    {
        $section = $this->vume->section('section-test')->call();

        $this->assertInstanceOf(Entry::class, $section->entry());
    }

    public function testSectionEntryFieldValue()
    {
        $entry = $this->vume->section('section-test')->call()->entry();

        $this->assertNotNull($entry->field('text'));
    }

    public function testSectionEntryShorthandFunction()
    {
        $entry = $this->vume->section('section-test')->entry();

        $this->assertInstanceOf(Entry::class, $entry);
    }

    public function testSectionEntryRelations()
    {
        $entry = $this->vume->section('section-test')->entry();

        dd($entry->relations());

        $this->assertInstanceOf(Relations::class, $entry->relations());
    }
}
