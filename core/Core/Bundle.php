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


/**
 * Gère l'inclusion de dépendances
 *
 * Class Bundle
 * @package Core
 */
class                               Bundle {
    /**
     * @var array $loaded           Liste des dépendances chargées
     */
    public static                   $loaded = [];
    /**
     * @var string $angularVersion  Détermine la version d'angularJS à charger
     */
    public static                   $angularVersion = '1.5.8';
    /**
     * @var string $angularMaterialVersion Détermine la version d'Angular Material à charger
     */
    public static                   $angularMaterialVersion = '1.1.0';
    /**
     * @var string $jQueryVersion   Détermine la version de jQuery à charger
     */
    public static                   $jQueryVersion = '2.2.4';

    /**
     * Charge l'icon font de Material.io
     */
    public static function          materialIcons() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.css', 'https://fonts.googleapis.com/icon?family=Material+Icons');
    }

    /**
     * Charge une Google Font
     *
     * @param string $font          Nom de la police
     * @param string $sizes         Graisses à charger
     */
    public static function          googleFont($font, $sizes = '300,400,700') {
        if (in_array(__FUNCTION__ . '::' . $font . ':' . $sizes, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__ . '::' . $font . ':' . $sizes;
        Conf::append('page.css', 'https://fonts.googleapis.com/icon?family=' . urlencode($font) . ':' . $sizes);
    }

    /**
     * Charge jQuery
     */
    public static function          jQuery() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://code.jquery.com/jquery-' . self::$jQueryVersion . '.min.js');
    }

    /**
     * Charge AngularJS
     */
    public static function          angular() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;

        self::jQuery();
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular.min.js');
    }

    /**
     * Charge le module Animate d'AngularJS
     */
    public static function          angularAnimate() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-animate.min.js');
    }

    /**
     * Charge le module Aria d'AngularJS
     */
    public static function          angularAria() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-aria.min.js');
    }

    /**
     * Charge le module Cookies d'AngularJS
     */
    public static function          angularCookies() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-cookies.min.js');
    }

    /**
     * Charge le module Loader d'AngularJS
     */
    public static function          angularLoader() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-loader.min.js');
    }

    /**
     * Charge le module MessageFormat d'AngularJS
     */
    public static function          angularMessageFormat() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-message-format.min.js');
    }

    /**
     * Charge le module Messages d'AngularJS
     */
    public static function          angularMessages() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-messages.min.js');
    }

    /**
     * Charge le module ParseExt d'AngularJS
     */
    public static function          angularParseExt() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-parse-ext.min.js');
    }

    /**
     * Charge le module Resource d'AngularJS
     */
    public static function          angularResource() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-resource.min.js');
    }

    /**
     * Charge le module Route d'AngularJS
     */
    public static function          angularRoute() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-route.min.js');
    }

    /**
     * Charge le module Sanitize d'AngularJS
     */
    public static function          angularSanitize() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-sanitize.min.js');
    }

    /**
     * Charge le module Touch d'AngularJS
     */
    public static function          angularTouch() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angularjs/' . self::$angularVersion . '/angular-touch.min.js');
    }

    /**
     * Charge Angular Material
     */
    public static function          angularMaterial() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;

        self::angular();
        self::angularAnimate();
        self::angularAria();
        self::angularMessages();
        Conf::append('page.js', 'https://ajax.googleapis.com/ajax/libs/angular_material/' . self::$angularMaterialVersion . '/angular-material.min.js');
        Conf::append('page.css', 'https://ajax.googleapis.com/ajax/libs/angular_material/' . self::$angularMaterialVersion . '/angular-material.min.css');
    }

    /**
     * Charge les classes nécessaires à l'utilisation de l'API interne
     */
    public static function          api() {
        if (in_array(__FUNCTION__, self::$loaded))
            return;
        self::$loaded[] = __FUNCTION__;

        Conf::append('page.js', '/js/api/client.min.js');
        Conf::append('page.bottom', '<script type="text/javascript">window.api.setLang("' . Conf::get('lang') . '") && window.api.setToken("' . Session::$id . '")</script>');
    }
}