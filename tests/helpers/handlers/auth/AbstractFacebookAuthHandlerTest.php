<?php
require_once("apps/facebook/helpers/auth/auth.php");

class AbstractFacebookAuthHandlerTest extends PHPUnit_Framework_TestCase {

    public function testFactoryReturnsCorrectClassForValidMode() {
        $this->assertTrue(
            FacebookAuthHandler::factory("live") instanceof LiveFacebookAuthHandler
        );
    }

    public function testFactoryReturnsNullForInvalidMode() {
        $this->assertSame(
            null,
            FacebookAuthHandler::factory("invalid")
        );
    }

    public function testGetAuthUrlReturnsCorrectQueryString() {
        $stub = $this->getMockForAbstractClass("FacebookAuthHandler", array(), '', true, true, true, array('getAuthBase'));

        $stub->expects($this->any())
             ->method("getAuthBase")
             ->will($this->returnValue("http://foo.com"));

        $this->assertEquals(
            "http://foo.com?client_id=1234&redirect_uri=http%3A%2F%2Fbar.com%3Fsk%3Dapp_1234",
            $stub->getAuthUrl(array(
                "appId" => 1234,
                "pageUrl" => "http://bar.com"
            ))
        );
    }
}
