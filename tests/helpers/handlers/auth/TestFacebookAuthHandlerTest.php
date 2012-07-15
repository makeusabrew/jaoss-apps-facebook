<?php

class TestFacebookAuthHandlerTest extends PHPUnit_Framework_TestCase {
    public function testGetAuthBase() {
        $handler = new TestFacebookAuthHandler();
        $this->assertEquals("test/auth", $handler->getAuthBase());
    }

    public function testParseSignedRequestWithValidStubReturnsExpectedArray() {
        $handler = new TestFacebookAuthHandler();

        $result = $handler->parseSignedRequest("authed", "test_secret");

        $this->assertEquals($result["oauth_token"], "my_fake_authed_token");
    }
}
