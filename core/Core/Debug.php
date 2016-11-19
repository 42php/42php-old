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

namespace                       Core;

/**
 * Gère le mode debug
 *
 * Class Debug
 * @package Core
 */
class                           Debug {
    /**
     * Affiche l'exécution de la fonction courante.
     */
    public static function      trace() {
        if (!Conf::get('debug', false) || !isset($_GET['trace']))
            return;
        $trace = debug_backtrace();
        if (!isset($trace[1]))
            return;
        $trace = $trace[1];
        $className = [];
        foreach (['class', 'type', 'function'] as $type)
            if (isset($trace[$type]))
                $className[] = $trace[$type];
        if (sizeof($className))
            $className[] = '(';
        if (isset($trace['args']) && sizeof($trace['args']))
            $className[] = '"' . implode('", "', $trace['args']) . '"';
        if (sizeof($className))
            $className[] = ')';
        echo '[' . date('H:i:s.') . intval(floatval(microtime()) * 10000) . '] ' . implode('', $className) . ' called in ' . $trace['file'] . ' at line ' . $trace['line'] . "\n";
    }
}