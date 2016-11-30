<?php

/**
 * Class Api_Auth
 */
trait                   Api_Auth {
    public function     auth() {
        \Core\Api::post('/session', function() {
            if (!isset($_REQUEST['email'], $_REQUEST['password']))
                \Core\Api::error(400);
            $ret = User::login($_REQUEST['email'], $_REQUEST['password']);
            if (!$ret)
                \Core\Api::error(403);
            return \Core\Session::get('user');
        });

        \Core\Api::delete('/session', function() {
            if (!\Core\Auth::logged())
                \Core\Api::error(403);
            \Core\Auth::logout(false);
            \Core\Api::code(204);
        });
    }
}