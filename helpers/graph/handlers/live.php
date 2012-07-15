<?php

require_once("apps/facebook/helpers/graph/handlers/abstract.php");

class LiveFacebookGraphHandler extends FacebookGraphHandler {
    protected function requestData($method, $params = array()) {
        $url = "https://graph.facebook.com/".$method;
        if (count($params)) {
            $url .= "?".http_build_query($params);
        }

        Log::debug("Raw FB request: [".$url."]");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        Log::debug("FB graph raw response: [".$response."]");

        return $response;
    }
}
