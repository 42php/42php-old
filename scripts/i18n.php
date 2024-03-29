<?php

if (isset($_GET['setLang']) && in_array($_GET['setLang'], \Core\i18n::$__acceptedLanguages)) {
    \Core\i18n::setLang($_GET['setLang']);
    \Core\Session::save();
    unset($_GET['setLang']);

    if (\Core\Conf::get('route') !== false) {
        $url = \Core\Argv::createUrl(\Core\Conf::get('route.name'), \Core\Conf::get('route.params'));
        if (sizeof($_GET))
            $url .= '?'.http_build_query($_GET);
        \Core\Redirect::http($url);
    }
}