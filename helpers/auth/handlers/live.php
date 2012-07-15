<?php

require_once("apps/facebook/helpers/auth/handlers/abstract.php");

class LiveFacebookAuthHandler extends FacebookAuthHandler {
    public function parseSignedRequest($request, $secret) {
        // lifted straight from FB really...
        list($encoded_sig, $payload) = explode('.', $request, 2); 

        // decode the data
        $sig = $this->base64_url_decode($encoded_sig);
        $data = json_decode($this->base64_url_decode($payload), true);

        if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
            Log::warn('Unknown algorithm. Expected HMAC-SHA256');
            return null;
        }

        // check sig
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
            Log::warn('Bad Signed JSON signature!');
            return null;
        }

        return $data;
    }

    public function getAuthBase() {
        return "https://www.facebook.com/dialog/oauth/";
    }

    protected function base64_url_decode($input) {
      return base64_decode(strtr($input, '-_', '+/'));
    }
}
