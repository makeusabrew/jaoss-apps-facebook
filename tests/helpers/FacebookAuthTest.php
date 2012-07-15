<?php
require_once("apps/facebook/helpers/auth/auth.php");

class FacebookAuthTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->helper = FacebookAuth::getInstance("test");
    }

    public function testGetReturnsNullIfDataKeyNotPresent() {
        $this->assertSame(null, $this->helper->get('foo'));
    }

    public function testGetReturnsValueIfDataKeyPresent() {
        $this->helper->setData(array(
            "foo" => "bar",
        ));

        $this->assertEquals("bar", $this->helper->get('foo'));
    }

    public function testGetOauthTokenReturnsCorrectKeyValue() {
        $this->helper->setData(array(
            "oauth_token" => "key123",
        ));

        $this->assertEquals("key123", $this->helper->getOauthToken());
    }

    public function testGetAuthUrlRespectsCorrectAppIdAndPageUrl() {
        // where do all these magic values come from? They're the test mode settings.
        $pageUrl = Settings::getValue("facebook", "page_url");
        $this->assertEquals(
            "test/auth?client_id=123456&redirect_uri=".urlencode($pageUrl)."%3Fsk%3Dapp_123456",
            $this->helper->getAuthUrl()
        );
    }

    public function testParseSignedRequestRespectsCorrectAppSecret() {
        $result = $this->helper->parseSignedRequest("authed");

        // we're just ensuring that the 'secret' has been tacked on; if it has,
        // the correct stub will be picked up and this assertion will pass
        $this->assertEquals("my_fake_authed_token", $result['oauth_token']);
    }

    public function testIsAuthedIsFalseWithNoData() {
        $this->assertFalse($this->helper->isAuthed());
    }

    public function testIsAuthedIsFalseWithUserIdOnly() {
        $this->helper->setData(array(
            "user_id" => "foo",
        ));
        $this->assertFalse($this->helper->isAuthed());
    }

    public function testIsAuthedIsFalseWithOauthTokenOnly() {
        $this->helper->setData(array(
            "oauth_token" => "foo",
        ));
        $this->assertFalse($this->helper->isAuthed());
    }

    public function testIsAuthedIsTrueWithUserIdAndOauthToken() {
        $this->helper->setData(array(
            "user_id"     => "foo",
            "oauth_token" => "bar",
        ));
        $this->assertTrue($this->helper->isAuthed());
    }
}
