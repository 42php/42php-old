<?php

use Core\Api,
    Core\Conf,
    Core\Auth,
    Core\Session;

/**
 * Class Api_Auth
 */
trait                   Api_Auth {
    public function     auth() {
        Api::post('/session', function() {
            Api::needFields(['email', 'password']);
            $ret = User::login($_REQUEST['email'], $_REQUEST['password']);
            if (!$ret)
                Api::error(403);
            return Session::get('user');
        });

        Api::delete('/session', function() {
            if (!Auth::logged())
                Api::error(403);
            Auth::logout(false);
            Api::code(204);
        });

        Api::post('/user', function() {
            if (!Conf::get('auth.allowRegister', false))
                Api::error(403);
            Api::needFields(['email', 'password', 'password2']);

            if (!strlen($_REQUEST['email']) || !filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL))
                Api::error(500, _t("L'adresse e-mail n'est pas valide."));

            if (!strlen($_REQUEST['password']) || $_REQUEST['password'] != $_REQUEST['password2'])
                Api::error(400, _t("Les mots de passe doivent être identiques."));

            $checkEmail = User::findOne(['email' => $_REQUEST['email']]);
            if ($checkEmail)
                Api::error(409, _t("Un utilisateur existe déjà avec cette adresse e-mail."));

            $u = new User();
            $u->set('email', $_REQUEST['email']);
            $u->setPassword($_REQUEST['password']);

            foreach (['gender', 'firstname', 'lastname'] as $key)
                if (isset($_REQUEST[$key]))
                    $u->set($key, $_REQUEST[$key]);
            $u->save();

            Api::code(201);
        });
    }
}