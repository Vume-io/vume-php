<?php

namespace Vume\Tests;

use Vume\Classes\Entries;
use Vume\Modules\ListModule;
use Vume\Exceptions\ListNotFoundException;

class ListTest extends BaseTest
{
    public function testListInstance()
    {
        $list = $this->vume->list('list-test');

        $this->assertInstanceOf(ListModule::class, $list);
    }

    public function testListNotFoundException()
    {
        $this->expectException(ListNotFoundException::class);

        $this->vume->list('non-existing-list')->call();
    }

    public function testEntriesFromList()
    {
        $list = $this->vume->list('list-test')->call();

        $this->assertInstanceOf(Entries::class, $list->entries());
    }

    public function testListEntryFieldValue()
    {
        $entries = $this->vume->list('list-test')->call()->entries();

        $this->assertNotNull($entries->first()->field('text')->value());
    }

    public function testListEntryFieldShorthandValue()
    {
        $entries = $this->vume->list('list-test')->call()->entries();
        $this->assertNotNull($entries->first()->value('text'));
        $this->assertEquals($entries->first()->field('text')->value(), $entries->first()->value('text'));
    }

    public function testListEntryFieldImage()
    {
        $entries = $this->vume->list('list-test')->call()->entries();

        $field = $entries->first()->field('image');



        $this->assertNotNull($field->value());

        $this->assertNotNull($field->value('url'));
        $this->assertNotNull($field->versions()->value());
        $this->assertNotNull($field->version('thumbnail')->value('url'));
    }

    public function testListEntriesShorthandFunction()
    {
        $entries = $this->vume->list('list-test')->entries();

        $this->assertInstanceOf(Entries::class, $entries);
    }

    public function testLimitClauseInList()
    {
        $list = $this->vume->list('list-test')->limit(2)->call();

        $this->assertEquals(2, $list->entries()->count());
    }

    public function testOffsetClauseInList()
    {
        $list = $this->vume->list('list-test')->offset(1)->call();

        $this->assertEquals('Test 2', $list->entries()->first()->field('text')->value());
    }

    public function testWhereClauseInList()
    {
        $entry = $this->vume->list('list-test')->where('fields.text', 'Test 2')->first();

        $this->assertEquals('Test 2', $entry->field('text')->value());
    }

    public function testSearchClauseInList()
    {
        $entry = $this->vume->list('list-test')->search('fields.text', '2')->first();
        $this->assertEquals('Test 2', $entry->field('text')->value());
    }
}
