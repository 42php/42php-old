<?php

/**
 * Class AdminController
 */
class                   AdminController extends \Core\Controller {
    public function     display() {
        return \Core\Plugin::render('Admin');
    }
}