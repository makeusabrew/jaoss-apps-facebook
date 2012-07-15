<?php

require_once("apps/facebook/helpers/auth/exceptions/auth.php");

abstract class FacebookAuthHandler {
    abstract public function getAuthBase();

    protected function base64_url_decode($input) {
      return base64_decode(strtr($input, '-_', '+/'));
    }

    public function parseSignedRequest($request, $secret) {
        // lifted straight from FB really...
        list($encoded_sig, $payload) = explode('.', $request, 2); 

        // decode the data
        $sig = $this->base64_url_decode($encoded_sig);
        $data = json_decode($this->base64_url_decode($payload), true);

        if (!isset($data['algorithm']) || strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
            Log::warn('Unknown algorithm. Expected HMAC-SHA256');
            throw new FacebookAuthException("Unknown or invalid algorithm");
        }

        // check sig
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
            Log::warn('Bad Signed JSON signature!');
            throw new FacebookAuthException("Bad signature");
        }

        return $data;
    }

    public function getAuthUrl($params) {
        return $this->getAuthBase().
            "?client_id=".$params['appId'].
            "&redirect_uri=".urlencode(
                $params['pageUrl']."?sk=app_".$params['appId']
            );
    }

    public static function factory($mode) {
        $prefix = ucfirst(strtolower($mode));
        if (class_exists($prefix."FacebookAuthHandler")) {
            $class = $prefix."FacebookAuthHandler";
            return new $class;
        }
    }
}
