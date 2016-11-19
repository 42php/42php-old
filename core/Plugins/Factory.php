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

namespace                   Plugins;

/**
 * Gère un plugin
 *
 * Interface Factory
 * @package Plugins
 */
interface                   Factory {
    /**
     * Retourne l'instance du plugin
     *
     * @return mixed
     */
    public static function  getInstance();

    /**
     * Retourne le code HTML généré par le plugin
     *
     * @return mixed
     */
    public function         render();
}