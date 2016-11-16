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

namespace                       Drivers\Database\PDO;

/**
 * Class Collection
 * @package Drivers\Database\PDO
 */
class                           Collection implements \Drivers\Database\Collection {
    /**
     * @var null|\PDO           Contient l'objet PDO
     */
    private                     $pdo = null;

    /**
     * @var Factory|null        La factory
     */
    private                     $handler = null;

    /**
     * @var string $table       Nom de la table
     */
    private                     $table = '';

    /**
     * Collection constructor.
     *
     * @param string $tableName Nom de la table
     * @param Factory $handler  Handler
     * @param \PDO $pdo         Objet PDO
     */
    public function             __construct($tableName, $handler, $pdo) {
        $this->pdo = $pdo;
        $this->handler = $handler;
        $this->table = $tableName;
    }

    /**
     * Insère un document en base de données
     *
     * @param array $data       Document à insérer
     * @return string           ID du document inséré
     */
    public function             insert(&$data) {
        $query = MongoToSQL::insert($this->table, $data);
        $this->handler->exec($query);
        $data['id'] = $this->handler->lastId();
        return $data['id'];
    }

    /**
     * Met à jour un ou plusieurs documents
     *
     * @param array $clause     Clauses de recherche
     * @param array $data       Champs à modifier
     * @param array $options    Options de modification
     * @return mixed            Nombre de documents modifiés
     */
    public function             update($clause = [], $data = [], $options = []) {
        $limit = 1;
        if (isset($option['multiple']) && $option['multiple'])
            $limit = false;
        $query = MongoToSQL::update($this->table, $data, $clause, $limit);
        return $this->handler->exec($query);
    }

    /**
     * Sauvegarde un document (effectue un upsert)
     *
     * @param array $data       Document à enregistrer
     * @return mixed            Identifiant du document
     */
    public function             save(&$data) {
        if (isset($data['id'])) {
            $d = $data;
            unset($d['id']);
            $this->update([
                'id' => \Core\Db::id($data['id'])
            ], [
                '$set' => $d
            ]);
        } else {
            $this->insert($data);
        }
        return $data['id'];
    }

    /**
     * Trouve une liste de documents
     *
     * @param array $clause     Clause de recherche
     * @param array $fields     Champs à retourner
     * @param array $sort       Champs de tris
     * @param bool|int $skip    Nombre de documents à ignorer
     * @param bool|int $limit   Nombre de documents à retourner
     * @return array            Liste des documents
     */
    public function             find($clause = [], $fields = [], $sort = [], $skip = false, $limit = false) {
        $query = MongoToSQL::select($this->table, $clause, $fields, $sort, $skip, $limit);
        return $this->handler->query($query);
    }

    /**
     * Trouve un document
     *
     * @param array $clause     Clause de recherche
     * @param array $fields     Champs à retourner
     * @return mixed            Premier document trouvé
     */
    public function             findOne($clause = [], $fields = []) {
        $ret = $this->find($clause, $fields, [], false, 1);
        if (sizeof($ret))
            return $ret[0];
        return false;
    }

    /**
     * Supprime un ou plusieurs documents
     *
     * @param array $clause     Clause de recherche
     * @param array $options    Options de suppression
     * @return int              Nombre de documents supprimés
     */
    public function             remove($clause = [], $options = [])
    {
        $limit = false;
        if (isset($options['justOne']) && $options['justOne'])
            $limit = 1;
        $query = MongoToSQL::delete($this->table, $clause, $limit);
        return $this->handler->exec($query);
    }

    /**
     * Traite un champ avant son retour de la DB
     *
     * @param string $data          Chaîne de caractère
     * @return array|string|object  Chaîne traitée
     */
    public static function      fromDb($data) {
        if (substr($data, 0, 20) == '42php.db.json.array:')
            return \Core\JSON::toArray(substr($data, 20));
        if (substr($data, 0, 21) == '42php.db.json.object:')
            return \Core\JSON::toObject(substr($data, 21));
        return $data;
    }

    /**
     * Traite un champ avant son import en base
     *
     * @param mixed $data       Valeur
     * @return string           Résultat
     */
    public static function      toDb($data) {
        if (is_array($data))
            $data = '42php.db.json.array:'.json_encode($data);
        if (is_object($data))
            $data = '42php.db.json.object:'.json_encode($data);
        return $data;
    }
}