<?php
class UsersTableTest extends PHPUnit_Framework_Testcase {
    protected $table = null;

    public function setUp() {
        parent::setUp();
        $this->table = Table::factory("FacebookUsers");
    }

    public function testLoadFromSessionReturnsNonAuthedUserByDefault() {
        $user = $this->table->loadFromSession();
        $this->assertFalse($user->isAuthed());
    }

    public function testLoadFromSessionReturnsNonAuthedUserWithInvalidSessionUserId() {
        Session::getInstance()->user_id = 9999;
        $user = $this->table->loadFromSession();
        $this->assertFalse($user->isAuthed());
    }

    /*
    public function testLoadFromSessionReturnsAuthedUserWithValidSessionUserId() {
        Session::getInstance()->user_id = 1;
        $user = $this->table->loadFromSession();
        $this->assertTrue($user->isAuthed());
    }
    */
}
