<?php
/**
 * LICENSE: This source file is subject to version 3.0 of the GPL license
 * that is available through the world-wide-web at the following URI:
 * https://www.gnu.org/licenses/gpl-3.0.fr.html (french version).
 *
 * @author      Guillaume Gagnaire <contact@42php.com>
 * @link        https://www.github.com/42php/42php
 * @license     https://www.gnu.org/licenses/gpl-3.0.fr.html GPL
 */

namespace                           Core;


class                               Bundle {
    public static                   $loaded = [];
    public static                   $angularVersion = '1.5.8';
    public static                   $angularMaterialVersion = '1.1.0';

    public static function          angular() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular.min.js');
    }

    public static function          angularAnimate() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-animate.min.js');
    }

    public static function          angularAria() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-aria.min.js');
    }

    public static function          angularCookies() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-cookies.min.js');
    }

    public static function          angularLoader() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-loader.min.js');
    }

    public static function          angularMessageFormat() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-message-format.min.js');
    }

    public static function          angularMessages() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-messages.min.js');
    }

    public static function          angularParseExt() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-parse-ext.min.js');
    }

    public static function          angularResource() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-resource.min.js');
    }

    public static function          angularRoute() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-route.min.js');
    }

    public static function          angularSanitize() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-sanitize.min.js');
    }

    public static function          angularTouch() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-touch.min.js');
    }

    public static function          angularMaterial() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;

        self::angular();
        self::angularAnimate();
        self::angularAria();
        self::angularMessages();
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angular_material/' . self::$angularMaterialVersion . '/angular-material.min.js');
    }
}