<?php

namespace Vume\Tests;

use Vume\Classes\Entry;
use Vume\Classes\Relations;
use Vume\Modules\SectionModule;
use Vume\Exceptions\SectionNotFoundException;
use Vume\Modules\RelationModule;

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

        $this->assertEquals('Hello world', $entry->value('text'));
    }

    public function testSectionEntryFieldShorthandValue()
    {
        $entry = $this->vume->section('section-test')->call()->entry();

        $this->assertNotNull($entry->value('text'));
        $this->assertEquals($entry->field('text')->value(), $entry->value('text'));
    }

    public function testSectionEntryFieldTranslation()
    {
        $entry = $this->vume->section('section-test')->language('nl')->call()->entry();

        $this->assertEquals('Hello world nl', $entry->value('text'));
    }

    public function testSectionEntryShorthandFunction()
    {
        $entry = $this->vume->section('section-test')->entry();

        $this->assertInstanceOf(Entry::class, $entry);
    }

    public function testSectionEntryRelations()
    {
        $entry = $this->vume->section('section-test')->entry();

        $this->assertInstanceOf(Relations::class, $entry->relations());
    }

    public function testSectionEntryRelationsCanBeIterated()
    {
        $entry = $this->vume->section('section-test')->entry();

        foreach ($entry->relations() as $key => $relation) {
            $this->assertTrue($entry->relations()->valid($key));
        }
    }

    public function testSectionWithLoadedRelationEntries()
    {
        $entry = $this->vume->section('section-test')->withRelation('relations-test')->entry()->relation('relations-test')->entries()->first();

        $this->assertInstanceOf(Entry::class, $entry);
    }

    public function testSectionEntryDefaultLanguage()
    {
        $entry = $this->vume->setLanguage('nl')->section('section-test')->call()->entry();

        $this->assertEquals('Hello world nl', $entry->value('text'));;
    }

    public function testSectionEntryDefaultLanguageCanBeOverwritten()
    {
        $entry = $this->vume->setLanguage('nl')->section('section-test')->language('en')->call()->entry();

        $this->assertEquals('Hello world', $entry->value('text'));;
    }
}
