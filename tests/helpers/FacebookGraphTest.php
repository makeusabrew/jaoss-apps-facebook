<?php
require_once("apps/facebook/helpers/graph/graph.php");

class FacebookGraphTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->helper = FacebookGraph::getInstance("test");
    }

    public function testGetProxiesAccessTokenThroughToHandler() {
        // much like a few other tests for these FB helpers, this test
        // looks a bit odd. It's because the only way we can verify this behaviour
        // from here is to set the access token to the value of a known
        // stub on the filesystem. Not quite ideal. Could be improved (@todo?)

        $this->helper->setAccessToken("my_fake_authed_token");

        $result = $this->helper->get("me");

        // it also looks a bit odd here because all the get method really does is decode
        // JSON; so we end up sort of just asserting whether json_decode works...
        $this->assertEquals("Test", $result['first_name']);
        $this->assertEquals("User", $result['last_name']);
    }
}
