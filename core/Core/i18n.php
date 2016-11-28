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

namespace                            Core {
    /**
     * Class i18n
     * @package Core
     */
    class                            i18n {
        /** @var array $__translations Liste des traductions */
        public static $__translations = [];

        /** @var string $__defaultLanguage Langue par défaut */
        public static $__defaultLanguage = 'fr-FR';

        /** @var array $__acceptedLanguages Langues disponibles */
        public static $__acceptedLanguages = [];

        /**
         * Charge un fichier de langue
         *
         * @return bool             Retourne TRUE si le fichier de langue a bien été chargé, sinon FALSE.
         */
        public static function      load() {
            Debug::trace();
            if (!file_exists(ROOT . '/i18n/' . Conf::get('lang') . '.json'))
                return false;

            self::$__translations = JSON::toArray(ROOT . '/i18n/' . Conf::get('lang') . '.json');
            return true;
        }

        /**
         * Traduit une chaîne de caractères.
         *
         * @param string $key       Chaîne à traduire
         * @param array $params     Paramètres
         *
         * @return string           Chaîne traduite
         */
        public static function      get($key, $params = []) {
            Debug::trace();
            if (!isset(self::$__translations[$key])) {
                self::$__translations[$key] = $key;
                file_put_contents(ROOT . '/i18n/' . Conf::get('lang') . '.json', json_encode(self::$__translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_FORCE_OBJECT));
                return vsprintf($key, $params);
            }
            return vsprintf(self::$__translations[$key], $params);
        }

        /**
         * Initialise le système de traduction
         */
        public static function      init() {
            Debug::trace();
            self::$__acceptedLanguages = Conf::get('i18n.languages');
            self::$__defaultLanguage = Conf::get('i18n.default');

            if (Auth::uid()) {
                $user = Auth::user();
                $lang = $user->get('lang', self::$__defaultLanguage);
                if (!in_array($lang, self::$__acceptedLanguages))
                    $lang = self::$__defaultLanguage;
                Conf::set('lang', $lang);
            } else {
                if (Session::get('lang', false))
                    Conf::set('lang', Session::get('lang', false));
                else {
                    if (isset($_GET['lang']) && in_array($_GET['lang'], self::$__acceptedLanguages)) {
                        Conf::set('lang', $_GET['lang']);
                        Session::set('lang', $_GET['lang']);
                    } else {
                        $languages = explode(',', isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : self::$__defaultLanguage);
                        if (isset($languages[0]) && in_array($languages[0], self::$__acceptedLanguages))
                            Conf::set('lang', $languages[0]);
                        else
                            Conf::set('lang', self::$__defaultLanguage);
                    }
                }
            }
        }

        /**
         * Change la langue courante
         *
         * @param string $lang Langue à configurer
         * @param bool $reloadFile Détermine si les langues doivent être rechargées en live
         */
        public static function setLang($lang, $reloadFile = false) {
            Debug::trace();
            if (!in_array($lang, self::$__acceptedLanguages))
                $lang = self::$__defaultLanguage;
            Conf::set('lang', $lang);
            Session::set('lang', $lang);
            if ($reloadFile)
                self::load();
        }
    }
}

namespace {
    /**
     * Traduit une chaîne de caractères.
     *
     * @param string $key       Texte à traduire
     * @param array $params     Paramètres
     *
     * @return string           Chaîne traduite
     */
    function _t($key, $params = []) {
        return \Core\i18n::get($key, $params);
    }
}