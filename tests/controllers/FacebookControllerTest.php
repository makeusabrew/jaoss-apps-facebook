<?php

class FacebookControllerText extends PHPUnitTestController {
    public function testIndexActionWithNoSignedRequestShowsLoginLink() {
        $this->request->dispatch("/");

        $this->assertApp("facebook");
        $this->assertAction("index");
        $this->assertController("Facebook");
        $this->assertResponseCode(200);

        $this->assertBodyHasContents("Auth Url");
    }

    public function testIndexActionSendsP3PHeader() {
        $this->request->dispatch("/");

        $this->assertHeader("P3P", 'CP="CAO PSA OUR"');
    }

    public function testIndexActionWithEmptyPostSignedRequestDoesNotAuthUser() {
        $this->request
             ->setMethod("POST")
             ->setParams(array(
                "signed_request" => "",
             ))
             ->dispatch("/");

        $this->assertResponseCode(200);

        $this->assertBodyHasContents("Auth Url");
    }

    public function testIndexActionWithNotAuthedPostSignedRequestDoesNotAuthUser() {
        $this->request
             ->setMethod("POST")
             ->setParams(array(
                "signed_request" => $this->generateValidRequest(array("foo" => "bar")),
             ))
             ->dispatch("/");

        $this->assertResponseCode(200);

        $this->assertBodyHasContents("Auth Url");
    }

    public function testIndexActionWithValidPostSignedRequestAuthsUser() {
        $this->request
             ->setMethod("POST")
             ->setParams(array(
                "signed_request" => $this->generateValidRequest(array(
                    "user_id"     => 1234,
                    "oauth_token" => "my_fake_authed_token",
                ))
             ))
             ->dispatch("/");

        $this->assertResponseCode(200);

        $this->assertBodyDoesNotHaveContents("Auth Url");

        $this->assertBodyHasContents("Facebook ID: 1234");
        $this->assertBodyHasContents("Forename: Test");
        $this->assertBodyHasContents("Surname: User");
    }

    public function testSignedRequestWhichTriggersExceptionOnGraphLookupDoesNotAuthUser() {
        $this->request
             ->setMethod("POST")
             ->setParams(array(
                "signed_request" => $this->generateValidRequest(array(
                    "user_id"     => 1234,
                    "oauth_token" => "exception_token",
                ))
             ))
             ->dispatch("/");

        $this->assertResponseCode(200);

        $this->assertBodyHasContents("Auth Url");
        $this->assertBodyHasContents("Exception thrown by Graph API");
    }

    public function testSignedRequestWhichTriggersAuthExceptionDoesNotAuthUser() {
        $this->request
             ->setMethod("POST")
             ->setParams(array(
                "signed_request" => $this->generateInvalidRequest(array("foo" => "bar")),
             ))
             ->dispatch("/");

        $this->assertResponseCode(200);

        $this->assertBodyHasContents("Auth Url");
        $this->assertBodyHasContents("Exception thrown decoding signed request.");
    }

    protected function generateValidRequest($data) {
        return $this->generateRequest($data, true);
    }

    protected function generateInvalidRequest($data) {
        return $this->generateRequest($data, false);
    }

    protected function generateRequest($data, $hasAlgorithm) {
        $handler = new TestFacebookAuthHandler();
        if ($hasAlgorithm === true) {
            $data['algorithm'] = 'HMAC-SHA256';
        }
        return $handler->encodeSignedRequest(
            $data,
            Settings::getValue("facebook", "app_secret")
        );
    }
}
