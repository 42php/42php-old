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
 * Gère les modèles
 *
 * Class Model
 * @package Core
 */
trait                           Model {
    use InstantiatedConfData;

    /**
     * @var array $cache Cache for singleton instances
     */
    public static               $cache = [];

    /**
     * Récupère une instance Singleton de ce modèle
     *
     * @param string $id        ID du document
     *
     * @return Model            Le modèle instancié
     */
    public static function      __getInstance($id) {
        if (!isset(self::$cache[$id]))
            self::$cache[$id] = new self($id);
        return self::$cache[$id];
    }

    /**
     * Stocke le modèle dans le cache singleton
     *
     * @return bool             Détermine si le modèle a bien été stocké
     */
    public function             store() {
        if (is_null($this->id))
            return false;
        self::$cache[$this->id] = $this;
        return true;
    }

    /**
     * Nettoie le cache singleton
     *
     * @return bool
     */
    public static function      cleanCache() {
        self::$cache = [];
        return true;
    }

    /**
     * @var null|string $id     ID unique du document
     */
    public                      $id = null;
    private                     $full = true;
    private                     $isOk = true;

    /**
     * Model constructor.
     *
     * @param mixed $id         Identifiant du document
     * @param bool|array $d     Données à insérer dans le document
     * @param bool $full        Détermine si le document est entier ou pas
     */
    public function             __construct($id = null, $d = false, $full = true) {
        $this->full = $full;
        if (isset($this->__structure))
            $this->__data = $this->__structure;
        if (!is_null($id)) {
            $this->load($id);
        }
        if ($d) {
            if (isset($d['id'])) {
                $this->id = (string)$d['id'];
                unset($d['id']);
            }
            $this->__data = ArrayTools::recursiveMerge($this->__data, $d);
        }
        if (method_exists($this, '__init'))
            $this->__init();
    }

    /**
     * Retourne le status du chargement du modèle
     *
     * @return bool
     */
    public function             ok() {
        return $this->isOk;
    }

    /**
     * Exporte le modèle
     *
     * @return array
     */
    public function             export() {
        $d = $this->__data;
        $d['id'] = $this->id;

        if (method_exists($this, '__export'))
            return $this->__export($d);

        return $d;
    }

    public function             __toString() {
        return json_encode($this->export(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Récupère la collection du modèle courant
     *
     * @return mixed
     */
    public static function      collection() {
        return Db::getInstance()->__get(self::$__collection);
    }

    /**
     * Charge les données d'un modèle depuis MongoDB
     * @param $id
     */
    public function             load($id) {
        $this->isOk = false;
        $item = self::collection()->findOne([
            '_id' => Db::id($id)
        ]);
        if ($item) {
            $this->isOk = true;
            $this->id = (string)$item['id'];
            unset($item['id']);
            $this->__data = ArrayTools::recursiveMerge($this->__data, $item);
        }
    }

    /**
     * Sauvegarde le modèle en base de données.
     */
    public function             save() {
        $d = $this->__data;
        if (!is_null($this->id))
            $d['id'] = Db::id($this->id);
        if ($this->full || !isset($d['id']))
            self::collection()->save($d);
        else {
            $id = $d['id'];
            unset($d['id']);
            self::collection()->update([
                'id' => Db::id($id)
            ], [
                '$set' => $d
            ]);
            $d['id'] = $id;
        }
        $this->id = (string)$d['id'];
        if (method_exists($this, '__onSave'))
            $this->__onSave();
    }

    /**
     * Supprime les données du modèle en base.
     */
    public function             remove() {
        if (is_null($this->id))
            return;
        if (method_exists($this, '__onRemove'))
            $this->__onRemove();
        self::collection()->remove([
            'id' => Db::id($this->id)
        ]);
        $this->id = null;
    }

    /**
     * Duplique un objet
     *
     * @return self
     */
    public function             duplicate() {
        $d = $this->__data;
        if (isset($d['id']))
            unset($d['id']);
        return new self(null, $d, $this->full);
    }

    /**
     * Trouve une occurence du modèle.
     *
     * @param array $criteria   Champs de recherche
     * @param mixed $fields     Permet de retourner qu'une partie des champs
     *
     * @return bool|self        Le modèle instancié, ou false
     */
    public static function      findOne($criteria = [], $fields = false) {
        $item = self::collection()->findOne($criteria, $fields);
        if ($item)
            return new self(null, $item, $fields === false);
        return false;
    }

    /**
     * Trouve une ou plusieurs occurences du modèle.
     *
     * @param array $criteria   Champs de recherche
     * @param array $fields     Permet de retourner qu'une partie des champs
     * @param mixed $order      Permet de trier les résultats
     * @param mixed $skip       Permet de sauter des résultats
     * @param mixed $limit      Permet de limiter le nombre de résultats
     *
     * @return ModelIterator    Curseur de lecture
     */
    public static function      find($criteria = [], $fields = [], $order = false, $skip = false, $limit = false) {
        $items = self::collection()->find($criteria, $fields, $order, $skip, $limit);

        return new ModelIterator($items, get_called_class(), $fields);
    }

    /**
     * Met à jour un ou plusieurs documents.
     *
     * @param array $criteria   Champ de recherche
     * @param array $new_object Requête de mise à jour
     * @param bool $multiple    Détermine si la requête doit affecter un seul ou plusieurs documents
     *
     * @return int              Nombre de documents affectés
     */
    public static function      update($criteria = [], $new_object = [], $multiple = false) {
        return self::collection()->update($criteria, $new_object, ['multiple' => $multiple]);
    }
}