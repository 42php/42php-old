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

namespace                       Plugins\Admin;

/**
 * Gère le panneau d'administration
 *
 * Class Factory
 * @package Plugins\Admin
 */
class                           Factory implements \Plugins\Factory {
    /**
     * Stocke l'instance singleton
     *
     * @var null|Factory
     */
    private static              $singleton = null;
    /**
     * Retourne l'instance singleton du panneau d'administration
     *
     * @return Factory          Une instance
     */
    public static function      getInstance() {
        if (is_null(self::$singleton))
            self::$singleton = new self();
        return self::$singleton;
    }

    /**
     * @return mixed
     */
    public function render() {

    }
}