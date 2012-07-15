<?php

require_once("apps/facebook/helpers/graph/handlers/abstract.php");

class TestFacebookGraphHandler extends FacebookGraphHandler {
    protected function requestData($method, $params = array()) {
        $paramString = $params['access_token'];
        return file_get_contents(PROJECT_ROOT."apps/facebook/tests/stubs/graph/".$method."_".$paramString.".json");
    }
}
