<?php
require_once("apps/facebook/helpers/auth/handlers/abstract.php");
class FacebookAuth {
    protected static $instance = null;
    protected $handler = null;

    protected $appSecret;
    protected $appId;
    protected $pageUrl;

    protected $data = array();

    public static function getInstance($mode = null) {
        if (self::$instance === null) {
            self::$instance = new self($mode);
        }
        return self::$instance;
    }

    public function __construct($mode = null) {
        if ($mode === null) {
            $mode = Settings::getValue("facebook", "auth_handler", "live");
        }
        require_once("apps/facebook/helpers/auth/handlers/".$mode.".php");
        Log::debug("Initialising facebook auth handler [".$mode."]");

        $this->handler   = FacebookAuthHandler::factory($mode);

        $this->appId     = Settings::getValue("facebook", "app_id");
        $this->appSecret = Settings::getValue("facebook", "app_secret");
        $this->pageUrl   = Settings::getValue("facebook", "page_url");
    }

    public function parseSignedRequest($request) {
        return $this->handler->parseSignedRequest($request, $this->appSecret);
    }

    public function getAuthUrl() {
        return $this->handler->getAuthUrl(array(
            'appId'    => $this->appId,
            'pageUrl'  => $this->pageUrl,
        ));
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getOauthToken() {
        return $this->get('oauth_token');
    }

    public function get($param) {
        return isset($this->data[$param]) ? $this->data[$param] : null;
    }

    public function isAuthed() {
        return isset($this->data['user_id']) && isset($this->data['oauth_token']);
    }
}
