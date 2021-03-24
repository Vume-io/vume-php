<?php

namespace Vume\Tests;

use Vume\Classes\Entries;
use Vume\Modules\RelationModule;
use Vume\Exceptions\RelationNotFoundException;

class RelationTest extends BaseTest
{
    public function testSectionRelationInstance()
    {
        $entry = $this->vume->section('section-test')->entry();
        $relation = $entry->relations()->first();

        $this->assertInstanceOf(RelationModule::class, $relation);
    }

    public function testRelationCanBeFoundBySlug()
    {
        $entry = $this->vume->section('section-test')->entry();
        $relation = $entry->relation('relations-test');

        $this->assertInstanceOf(RelationModule::class, $relation);
    }

    public function testListRelationInstance()
    {
        $relation = $this->getListRelation();

        $this->assertInstanceOf(RelationModule::class, $relation);
    }

    public function testEntriesFromRelation()
    {
        $relation = $this->getListRelation();

        $this->assertInstanceOf(Entries::class, $relation->entries());
    }

    public function testRelationEntryFieldValue()
    {
        $entries = $this->getListRelation()->entries();

        $this->assertNotNull($entries->first()->field('text')->value());
    }

    public function testRelationEntryFieldShorthandValue()
    {
        $entries = $this->getListRelation()->entries();
        $this->assertNotNull($entries->first()->value('text'));
        $this->assertEquals($entries->first()->field('text')->value(), $entries->first()->value('text'));
    }

    public function testLimitClauseInRelation()
    {
        $relation = $this->getListRelation()->limit(2)->call();

        $this->assertEquals(2, $relation->entries()->count());
    }

    public function testOffsetClauseInRelation()
    {
        $relation = $this->getListRelation()->offset(1)->call();

        $this->assertEquals('Related 2', $relation->entries()->first()->field('text')->value());
    }

    public function testWhereClauseInRelation()
    {
        $entry = $this->getListRelation()->where('fields.text', 'Related 2')->first();

        $this->assertEquals('Related 2', $entry->field('text')->value());
    }

    public function testSearchClauseInRelation()
    {
        $entry = $this->getListRelation()->search('fields.text', '2')->first();

        $this->assertEquals('Related 2', $entry->field('text')->value());
    }

    /**
     * Get relation from list test
     */
    private function getListRelation()
    {
        $entry = $this->vume->list('list-test')->entries()->first();
        return $entry->relations()->first();
    }
}
