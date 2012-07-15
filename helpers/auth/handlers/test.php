<?php

require_once("apps/facebook/helpers/auth/handlers/abstract.php");

class TestFacebookAuthHandler extends FacebookAuthHandler {
    public function getAuthBase() {
        return "test/auth";
    }

    public function encodeSignedRequest($data, $secret) {

        $encodedData = base64_encode(json_encode($data));
        $encodedData = strtr($encodedData, '+/', '-_');
        $encodedData = str_replace('=', '', $encodedData);

        $signature = hash_hmac('sha256', $encodedData, $secret, true);

        $encodedSig = base64_encode($signature);
        $encodedSig = strtr($encodedSig, '+/', '-_');
        $encodedSig = str_replace('=', '', $encodedSig);

        return $encodedSig.".".$encodedData;
    }
}
