<?php
require_once("apps/facebook/helpers/graph/handlers/abstract.php");
class FacebookGraph {
    protected static $instance = null;
    protected $handler = null;

    protected $accessToken;

    public static function getInstance($mode = null) {
        if (self::$instance === null) {
            self::$instance = new self($mode);
        }
        return self::$instance;
    }

    public function __construct($mode = null) {
        if ($mode === null) {
            $mode = Settings::getValue("facebook", "graph_handler", "live");
        }
        require_once("apps/facebook/helpers/graph/handlers/".$mode.".php");
        Log::debug("Initialising facebook graph handler [".$mode."]");

        $this->handler = FacebookGraphHandler::factory($mode);
    }

    public function setAccessToken($token) {
        $this->accessToken = $token;
    }

    public function get($method, $params = array()) {
        $params['access_token'] = $this->accessToken;
        return $this->handler->get($method, $params);
    }
}
