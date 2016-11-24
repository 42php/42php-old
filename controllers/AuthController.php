<?php

/**
 * Class AuthController
 */
class                   AuthController extends \Core\Controller {
    public function     login() {
        return \Core\Plugin::render('MaterialAuth', [
            'view' => 'index',
            'conf' => \Core\Conf::get('auth', [])
        ]);
    }

    public function     logout() {
        $redirect = '/';
        if (isset($_GET['redirect']))
            $redirect = $_GET['redirect'];
        \Core\Auth::logout($redirect);
    }
}