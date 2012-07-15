<?php

class TestFacebookAuthHandlerTest extends PHPUnit_Framework_TestCase {
    public function testGetAuthBase() {
        $handler = new TestFacebookAuthHandler();
        $this->assertEquals("test/auth", $handler->getAuthBase());
    }

    public function testEncodeSignedRequest() {
        $handler = new TestFacebookAuthHandler();

        $data = array(
            "algorithm" => "HMAC-SHA256",
            "foo" => "bar",
            "baz" => "test",
        );

        $signedRequest = $handler->encodeSignedRequest(
            $data,
            "fake_secret"
        );

        $decodedData = $handler->parseSignedRequest(
            $signedRequest,
            "fake_secret"
        );

        $this->assertEquals(array(
            "algorithm" => "HMAC-SHA256",
            "foo" => "bar",
            "baz" => "test",
        ), $decodedData);
    }
}
