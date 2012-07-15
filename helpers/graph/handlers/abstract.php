<?php
require_once("apps/facebook/helpers/graph/exceptions/graph.php");
abstract class FacebookGraphHandler {
    abstract protected function requestData($method, $params = array());

    public function get($method, $params = array()) {
        return $this->processResponse(
            $this->decode(
                $this->requestData($method, $params)
            )
        );
    }


    public static function factory($mode) {
        $prefix = ucfirst(strtolower($mode));
        if (class_exists($prefix."FacebookGraphHandler")) {
            $class = $prefix."FacebookGraphHandler";
            return new $class;
        }
    }

    public function processResponse($data) {
        if (isset($data['error'])) {
            throw new FacebookGraphException(
                $data['error']['message'],
                $data['error']['code']
            );
        }

        return $data;
    }

    public function decode($data) {
        $result = json_decode($data, true);
        if ($result === null) {
            throw new FacebookGraphException(
                "Could not decode JSON"
            );
        }
        return $result;
    }

}
