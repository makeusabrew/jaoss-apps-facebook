<?php

class FacebookUser extends Object {
    protected $autoIncrement = false;

    /**
     * keep track of whether this user is authed (logged in)
     * or not
     */
    protected $isAuthed = false;

    /**
     * bung this user's ID in the session
     */
    public function addToSession() {
        $s = Session::getInstance();
        $s->user_id = $this->getId();
        if ($s->user_id === null) {
            Log::warn("Adding null user ID to session");
        }
        $this->setAuthed(true);
    }
    
    /**
     * remove this user from the session
     */
    public function logout() {
    	$s = Session::getInstance();
    	unset($s->user_id);
        $this->setAuthed(false);
    }

    /**
     * is this user authenticated?
     */
    public function isAuthed() {
        return $this->isAuthed;
    }

    /**
     * update this user's authed state
     */
    public function setAuthed($authed) {
        $this->isAuthed = $authed;
    }

}

class FacebookUsers extends Table {
    protected $meta = array(
        'columns' => array(
            "id" => array(
                "type" => "number",
                "validation" => "unsigned",
            ),
            "forename" => array(
                "type" => "text",
            ),
            "surname" => array(
                "type" => "text",
            ),
        ),
    );
    
    public function loadFromSession() {
        $s = Session::getInstance();
        $id = $s->user_id;
        if ($id === NULL) {
            return new FacebookUser();
        }
        $user = $this->read($id);
        if (!$user) {
            // oh dear
            Log::debug("Could not find user id [".$id."]");
            return new FacebookUser();
        }
        $user->setAuthed(true);
        return $user;
    }
}
