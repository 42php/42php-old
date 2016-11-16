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
 * Gère l'affichage des vues
 *
 * Class View
 * @package Core
 */
class                       View {
    /**
     * Check if a view file exists
     *
     * @param string $viewName View file name. Can have slashes to delimit folders.
     *
     * @return bool TRUE if the view file exists
     */
    public static function  exists($viewName) {
        return file_exists(ROOT.'/views/'.$viewName.'.php');
    }

    /**
     * Render a view file.
     *
     * @param string $viewName View file name. Can have slashes to delimit folders.
     * @param array $params Variables to pass to the view.
     * @param bool $generateHeader Defines if this method should render a HTML full body.
     *
     * @return string The rendered view.
     */
    private static function renderFile($viewName, $params, $generateHeader) {
        if (!self::exists($viewName))
            return '';
        extract($params);
        ob_start();
        if ($generateHeader && file_exists(ROOT.'/views/system/htmlheader.php'))
            include ROOT . '/views/system/htmlheader.php';
        include ROOT.'/views/'.$viewName.'.php';
        if ($generateHeader && file_exists(ROOT.'/views/system/htmlfooter.php'))
            include ROOT . '/views/system/htmlfooter.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    /**
     * Renders a view file with the HTML full body.
     *
     * @param string $viewName View file name. Can have slashes to delimit folders.
     * @param array $params Variables to pass to the view.
     *
     * @return string The rendered view.
     */
    public static function  render($viewName, $params = []) {
        return self::renderFile($viewName, $params, true);
    }

    /**
     * Renders a view file without the HTML full body. Useful to render a view inside another view.
     *
     * @param $viewName View file name. Can have slashes to delimit folders.
     * @param array $params Variables to pass to the view.
     *
     * @return string The rendered view.
     */
    public static function  partial($viewName, $params = []) {
        return self::renderFile($viewName, $params, false);
    }
}