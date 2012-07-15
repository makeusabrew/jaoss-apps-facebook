<?php
require_once("apps/facebook/helpers/graph/graph.php");

class AbstractFacebookGraphHandlerTest extends PHPUnit_Framework_TestCase {

    public function testFactoryReturnsCorrectClassForValidMode() {
        $this->assertTrue(
            FacebookGraphHandler::factory("live") instanceof LiveFacebookGraphHandler
        );
    }

    public function testFactoryReturnsNullForInvalidMode() {
        $this->assertSame(
            null,
            FacebookGraphHandler::factory("invalid")
        );
    }

    public function testProcessResponseThrowsExceptionIfErrorKeyPresent() {
        $stub = $this->getMockForAbstractClass("FacebookGraphHandler");

        try {
            $stub->processResponse(array(
                "error" => array(
                    "message" => "foo",
                    "code" => 123,
                ),
            ));
        } catch (FacebookGraphException $e) {
            $this->assertEquals("foo", $e->getMessage());
            $this->assertEquals(123, $e->getCode());
            return;
        }

        $this->fail("Expected exception not raised");
    }

    public function testProcessResponseReturnsExactDataWhenNoErrorPresent() {
        $stub = $this->getMockForAbstractClass("FacebookGraphHandler");

        $this->assertEquals(array(
            "key" => "val",
            "foo" => "var",
        ), $stub->processResponse(array(
            "key" => "val",
            "foo" => "var",
        )));
    }

    public function testDecodeThrowsExceptionWithInvalidJson() {
        $stub = $this->getMockForAbstractClass("FacebookGraphHandler");

        try {
            $stub->decode("invalid JSON");
        } catch (FacebookGraphException $e) {
            $this->assertEquals("Could not decode JSON", $e->getMessage());
            return;
        }

        $this->fail("Expected exception not raised");
    }

    public function testDecodeReturnsArrayWithValidJson() {
        $stub = $this->getMockForAbstractClass("FacebookGraphHandler");

        $result = $stub->decode('{"foo":"bar"}');
        $this->assertEquals(array(
            "foo" => "bar",
        ), $result);
    }

    public function testGetReturnsArrayForValidResponse() {
        $stub = $this->getMockForAbstractClass("FacebookGraphHandler", array(), '', true, true, true, array('requestData'));
        $stub->expects($this->any())
             ->method("requestData")
             ->will($this->returnValue('{"foo":"bar"}'));
        
        $this->assertEquals(array(
            "foo" => "bar",
        ), $stub->get("ignore"));
    }
}
