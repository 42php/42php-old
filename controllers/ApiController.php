<?php

use                     Core\Plugin;

/**
 * Class ApiController
 */
class                   ApiController extends \Core\Controller {
    use                 Api_Auth;

    public function     process() {
        $methods = get_class_methods($this);
        foreach ($methods as $method) {
            if (in_array($method, ['process', '__construct', 'run', 'exists']))
                continue;
            $this->$method();
        }

        Plugin::loadApiEndpoints();

        \Core\Api::run(1);
    }
}