<?php

class TestFacebookGraphHandlerTest extends PHPUnit_Framework_TestCase {
    public function testGetReturnsArrayForValidStub() {
        $handler = new TestFacebookGraphHandler();
        $result = $handler->get("me", array("access_token" => "my_fake_authed_token"));

        $this->assertEquals("Test", $result['first_name']);
    }
}
