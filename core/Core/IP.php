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

namespace                   Core;

/**
 * Gère les IP
 *
 * Class IP
 * @package Core
 */
class 						IP {
    /**
     * Détermine l'IP réelle du client
     *
     * @return string       IP du client
     */
    public static function 	get() {
        Debug::trace();
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
        if(filter_var($client, FILTER_VALIDATE_IP))
            $ip = $client;
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
            $ip = $forward;
        else
            $ip = $remote;
        return $ip;
    }
}