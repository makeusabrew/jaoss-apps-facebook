<?php
abstract class FacebookAuthHandler {
    abstract public function parseSignedRequest($request, $secret);
    abstract public function getAuthBase();

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
