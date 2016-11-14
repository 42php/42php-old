<?php

namespace                       Core;

/**
 * Gère la session
 *
 * Class Session
 * @package Core
 */
class 							Session {
    use ConfData;

    /**
     * @var bool $apiMode       Utilisation, ou non, du mode API
     */
    public static               $apiMode = false;

    /**
     * @var string $__expire    Chaîne strtotime() décrivant l'expiration de la session
     */
    public static               $__expire = '+30 hours';

    /**
     * @var mixed               ID de session (false si aucun ID, sinon ID du document MongoDB)
     */
    public static               $id = false;

    /**
     * Initialisation de la session
     */
    public static function      init() {
        /**
         * If it's cookie mode (for web)
         */
        if (!self::$apiMode && isset($_COOKIE['token'])) {
            self::$id = $_COOKIE['token'];
        }

        /**
         * If the session id is transmitted via API (via X-Token header)
         */
        if (self::$apiMode) {
            $headers = Http::headers();
            if (isset($headers['X-Token'])) {
                self::$id = $headers['X-Token'];
            }
        }

        /**
         * Clean old sessions
         */
        Db::getInstance()->Sessions->remove([
            'expire' => [
                '$lt' => new MongoDate()
            ]
        ]);

        /**
         * If a session id was transmitted, we try to get data from DB
         */
        if (self::$id !== false) {
            $d = Db::getInstance()->Sessions->findOne([
                '_id' => new MongoId(self::$id)
            ]);
            if (!$d) {
                self::$id = false;
                if (self::$apiMode) {
                    Session::set('__apiSpecial.deleteToken', true);
                }
            } else
                self::$__data = $d['data'];
        }
        self::save();

        register_shutdown_function(function(){
            Session::save();
        });
    }

    /**
     * Création d'une session.
     */
    public static function      create() {
        if (self::$id === false) {
            $d = ['data' => self::$__data, 'expire' => new MongoDate(strtotime(self::$__expire))];
            Db::getInstance()->Sessions->insert($d);
            self::$id = (string)$d['_id'];
            Session::set('__apiSpecial.storeToken', self::$id);
        }
    }

    /**
     * Enregistrement de la session en base
     */
    public static function      save() {
        $d = ['data' => self::$__data, 'expire' => new MongoDate(strtotime(self::$__expire))];
        /**
         * If no active session, create a new session in DB, or update data in DB
         * If we are in API mode, no session will be created
         *
         * For the API mode, we can force the session creation with Session::create()
         */
        if (!self::$apiMode && self::$id === false) {
            Db::getInstance()->Sessions->insert($d);
            self::$id = (string)$d['_id'];
        } elseif (self::$id !== false) {
            if (isset($d['_id']))
                unset($d['_id']);
            Db::getInstance()->Sessions->update([
                '_id' => new MongoId(self::$id)
            ], $d);
        }
        if (!self::$apiMode) {
            if (!headers_sent()) {
                setcookie('token', self::$id, strtotime(self::$__expire), '/', Conf::get('cookie.domain'), false, false); // The cookie must be accessible by javascript.
            }
        } else {
            Session::set('__apiSpecial.storeToken', self::$id);
        }
    }

    /**
     * Destruction de la session
     */
    public static function      destroy() {
        self::$__data = [];
        if (self::$id !== false) {
            Db::getInstance()->Sessions->remove([
                '_id' => new MongoId(self::$id)
            ]);
            self::$id = false;
        }
        self::save();
    }
}