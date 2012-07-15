<?php

require_once("apps/facebook/helpers/auth/handlers/abstract.php");

class TestFacebookAuthHandler extends FacebookAuthHandler {
    public function parseSignedRequest($request, $secret) {
        $path = PROJECT_ROOT."apps/facebook/tests/stubs/auth/".$request.".".$secret.".json";
        Log::debug("Looking for signed request data in [".$path."]");

        return json_decode(
            file_get_contents($path),
            true
        );
    }

    public function getAuthBase() {
        return "test/auth";
    }
}
