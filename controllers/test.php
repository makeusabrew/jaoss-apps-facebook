<?php

class TestController extends Controller {
    public function iframe() {
        return $this->render("test/iframe");
    }

    public function auth() {
        return $this->render("test/auth");
    }
}
