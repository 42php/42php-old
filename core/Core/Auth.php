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
 * Gère l'authentification
 *
 * Class Auth
 * @package Core
 */
class                               Auth {
    /**
     * Retourne l'ID de l'utilisateur
     *
     * @return bool|mixed           Si il est connecté, retourne l'ID de l'utilisateur, sinon FALSE
     */
    public static function          uid() {
        Debug::trace();
        if (Auth::logged())
            return Session::get('user.id');
        return false;
    }

    /**
     * Détermine si l'utilisateur est connecté ou pas.
     *
     * @return bool                 Retourne TRUE si l'utilisateur est connecté, sinon FALSE
     */
    public static function          logged() {
        Debug::trace();
        $uid = Session::get('user.id', false);
        if ($uid !== false)
            return true;
        return false;
    }

    /**
     * Détermine si l'utilisateur est administrateur ou pas.
     *
     * @return bool                 Retourne TRUE si l'utilisateur est administrateur, sinon FALSE
     */
    public static function          admin() {
        Debug::trace();
        return Session::get('user.admin', false);
    }

    /**
     * Si l'utilisateur n'est pas connecté, le redirige vers la page de connexion
     *
     * @param bool $asAdmin         Détermine si l'utilisateur doit être connecté avec un compte admin ou pas.
     * @return bool                 TRUE si il est connecté
     */
    public static function          needConnection($asAdmin = false) {
        if (($asAdmin && !self::admin()) || (!$asAdmin && !self::logged())) {
            Redirect::http(
                Argv::createUrl('login') .
                '?redirect=' . urlencode($_SERVER['REQUEST_URI'])
            );
        }
        return true;
    }

    /**
     * Retourne une instance de l'User connecté.
     *
     * @return bool|\User  Retourne l'utilisateur si il est connecté, sinon FALSE
     */
    public static function          user() {
        Debug::trace();
        if (!Auth::logged())
            return false;
        $user = new \User(Session::get('user.id', ''));
        return $user;
    }

    /**
     * Se déconnecte, puis redirige l'utilisateur
     *
     * @param string|bool $redirect URL de redirection. Si FALSE, ne redirige pas l'utilisateur.
     */
    public static function          logout($redirect = '/') {
        Debug::trace();
        Session::destroy();
        if ($redirect !== false)
            Redirect::http($redirect);
    }
}