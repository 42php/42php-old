<?php

/**
 * Class StaticController
 */
class                   StaticController extends \Core\Controller {
    public function     home() {
        return \Core\View::render('home');
    }

    public function     redirectToLang() {
        \Core\Redirect::http(\Core\Argv::createUrl('home'));
    }
}