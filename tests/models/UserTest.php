<?php

class UserTest extends PHPUnit_Framework_TestCase {
    protected $object = null;

    public function setUp() {
        parent::setUp();
        $this->object = Table::factory('FacebookUsers')->newObject();
    }

    public function tearDown() {
        $this->object = null;
        parent::tearDown();
    }

    public function testNewObjectIsNotAuthed() {
        $this->assertFalse($this->object->isAuthed());
    }

    public function testSetAuthed() {
        $this->object->setAuthed(true);
        $this->assertTrue($this->object->isAuthed());

        $this->object->setAuthed(false);
        $this->assertFalse($this->object->isAuthed());
    }

    public function testAddToSessionSetsUserAsAuthed() {
        $this->object->addToSession();
        $this->assertTrue($this->object->isAuthed());
    }

    public function testLogoutSetsUserAsNotAuthed() {
        $this->object->addToSession();
        $this->object->logout();
        $this->assertFalse($this->object->isAuthed());
    }
}
