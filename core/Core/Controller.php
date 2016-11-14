<?php

namespace                       Core;

/**
 * Gère l'exécution des contrôleurs.
 *
 * Class Controller
 * @package Core
 */
class 							Controller {
    /** @var int $argc Nombre d'arguments */
    protected					$argc;

    /** @var array $argv Tableau d'arguments */
    protected					$argv;

    /**
     * Controller constructor.
     *
     * @param int $argc     Nombre d'arguments
     * @param array $argv   Tableau d'arguments
     */
    public function 			__construct($argc, $argv) {
        foreach (['argc', 'argv'] as $item)
            $this->$item = $$item;
    }

    /**
     * Vérifie si un contrôleur existe ou pas.
     *
     * @param string $name      Nom du controlleur
     *
     * @return bool             TRUE si le controlleur existe.
     */
    public static function      exists($name) {
        list($c, $m) = explode('@', $name);
        return class_exists($c);
    }

    /**
     * Exécute un controlleur et retourne le contenu généré.
     *
     * @param string $name      Nom du controlleur (sous la forme ControllerClass@methodName)
     * @param array $params     Liste des paramètres à fournir au controlleur
     *
     * @return string           Contenu généré par le controlleur
     */
    public static function 		run($name, $params = []) {
        global $argc, $argv;

        list($c, $m) = explode('@', $name);
        if (!class_exists($c))
            return '';
        $obj = new $c($argc, $argv);
        if (!method_exists($obj, $m))
            return '';
        return $obj->$m((object)$params);
    }
}

?>