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

    public function     register() {
        $conf = \Core\Conf::get('auth', []);
        if (!isset($conf['allowRegister']) || !$conf['allowRegister'])
            \Core\Redirect::http(\Core\Argv::createUrl('login') . (isset($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : ''));
        return \Core\Plugin::render('MaterialAuth', [
            'view' => 'register',
            'conf' => $conf
        ]);
    }

    public function     resetPassword() {
        return \Core\Plugin::render('MaterialAuth', [
            'view' => 'password-forgot',
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