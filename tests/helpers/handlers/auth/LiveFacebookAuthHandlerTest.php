<?php

require_once("apps/facebook/helpers/auth/handlers/live.php");

class LiveFacebookAuthHandlerTest extends PHPUnit_Framework_TestCase {
    public function testGetAuthBase() {
        $handler = new LiveFacebookAuthHandler();
        $this->assertEquals("https://www.facebook.com/dialog/oauth/", $handler->getAuthBase());
    }

    public function testParseSignedRequestWithValidStubReturnsExpectedArray() {
        $handler = new LiveFacebookAuthHandler();

        // The following is a signed request + secret key I nabbed during ad hoc testing
        // Obviously it looks a bit weird for test data, but it is correct; we're really
        // just checking that the decoding mechanism is all OK
        $result = $handler->parseSignedRequest(
            "ZHGGSOHORNS27QfoP_O4TnQOrU0lsxqwmdqObMW2brY.eyJhbGdvcml0aG0iOiJITUFDLVNIQTI1NiIsImlzc3VlZF9hdCI6MTM0MTk5MjQxOSwicGFnZSI6eyJpZCI6IjQyMzc1NjUwMTAwMTEzNiIsImxpa2VkIjpmYWxzZSwiYWRtaW4iOnRydWV9LCJ1c2VyIjp7ImNvdW50cnkiOiJnYiIsImxvY2FsZSI6ImVuX1VTIiwiYWdlIjp7Im1pbiI6MjF9fX0",
            "03f36aec5ee15689f8dad1a9636672c3"
        );

        $this->assertEquals($result["algorithm"], "HMAC-SHA256");
    }
}
