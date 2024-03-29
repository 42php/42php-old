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
 * Gère le filesystem.
 *
 * Class Dir
 * @package Core
 */
class				        Dir {
    /**
     * Retourne la liste des fichiers d'un dossier, en chemin absolu.
     *
     * @param string $path          Dossier
     * @param bool $recursive       Lire de façon récursive
     * @param string $limit         Filtre fnmatch()
     *
     * @return array                Liste des fichiers
     */
    public static function	read($path, $recursive = false, $limit = '') {
        Debug::trace();
        $list = array();
        $path = realpath($path);
        if ($handle = opendir($path)) {
            while (false !== ($entry = readdir($handle)))
                if ($entry != '.' && $entry != '..') {
                    if ($limit == '' || fnmatch($limit, $entry))
                        $list[] = "$path/$entry";
                    if ($recursive && is_dir("$path/$entry"))
                        $list = array_merge($list, Dir::read("$path/$entry", true, $limit));
                }
            closedir($handle);
        }
        return $list;
    }
}