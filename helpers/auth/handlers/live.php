<?php

require_once("apps/facebook/helpers/auth/handlers/abstract.php");

class LiveFacebookAuthHandler extends FacebookAuthHandler {
    public function getAuthBase() {
        return "https://www.facebook.com/dialog/oauth/";
    }
}
