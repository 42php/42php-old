<?php

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