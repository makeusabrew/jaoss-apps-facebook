<?php

require_once("apps/facebook/helpers/auth/auth.php");
require_once("apps/facebook/helpers/graph/graph.php");

class FacebookController extends Controller {
    protected $user = null;

    public function init() {
        parent::init();

        $this->user = Table::factory('FacebookUsers')->loadFromSession();

        // always spit out a P3P header for session persistance stuff
        $this->response->addHeader("P3P", 'CP="CAO PSA OUR"');

        if ($this->user->isAuthed()) {
            // no need to perform any auth / graph logic if the user's already got a local session
            // this might not necessarily apply in a real-world app of course
            Log::debug("User [".$this->user->getId()."] already signed in, skipping FB auth");
            return;
        }

        // if we haven't got a local session, start the FB auth logic

        $fbAuth = FacebookAuth::getInstance();

        $signedRequest = $this->request->getVar("signed_request");

        if ($this->request->isPost() && $signedRequest != null) {

            try {
                $data = $fbAuth->parseSignedRequest($signedRequest);
            } catch (FacebookAuthException $e) {
                // this usually means the signed request wasn't legit, so we're done
                // we set a smarty variable just for the purposes of demonstration in this test app
                // but you could handle this however you see fit
                Log::warn("Got Facebook Auth exception [".$e->getCode()."] - [".$e->getMessage()."]");
                $this->assign('authError', true);
                return;
            }

            Log::debug("Got signed request: [".json_encode($data)."]");

            $fbAuth->setData($data);

            if ($fbAuth->isAuthed()) {
                Log::debug("Authenticating user based on signed request");

                $fbGraph = FacebookGraph::getInstance();

                $fbGraph->setAccessToken(
                    $fbAuth->getOauthToken()
                );

                try {
                    $data = $fbGraph->get('me');

                    $user = Table::factory('FacebookUsers')->read($data['id']);
                    if (!$user) {
                        Log::debug("No user in DB with ID [".$data['id']."], creating...");
                        $user = Table::factory('FacebookUsers')->newObject();
                    } else {
                        Log::debug("User [".$data['id']."] already exists, updating...");
                    }

                    // regardless of whether we're new or existing, update all our values
                    $user->setValues(array(
                        'id'       => $data['id'],
                        'forename' => $data['first_name'],
                        'surname'  => $data['last_name'],
                    ));
                    $user->save();
                    $user->setAuthed(true);
                    $user->addToSession();

                    $this->user = $user;
                } catch (FacebookGraphException $e) {
                    // any error states we get back from FB are converted to exceptions, along with some
                    // which are triggered by our own wrapper logic. You'd probably want to deal with
                    // these based on the code thrown by FB to decide how to react
                    Log::warn("Got Facebook Graph exception [".$e->getCode()."] - [".$e->getMessage()."]");
                    $this->assign('graphError', true);
                }
            }
        }
    }

    public function index() {
        if (!$this->user->isAuthed()) {
            $fbAuth = FacebookAuth::getInstance();
            Log::debug("User not authed, auth URL [".$fbAuth->getAuthUrl()."]");
            $this->assign('authUrl', $fbAuth->getAuthUrl());
        }

        $this->assign('user', $this->user);

        return $this->render("index");
    }
}
