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

/**
 * Class User
 */
class                       User {
    use \Core\Model;

    /** @var string $__collection Détermine la collection à utiliser */
    public static           $__collection = 'users';

    /** @var array Données par défaut des utilisateurs */
    public                  $__structure = [
        'email' => '',
        'password' => '',
        'firstname' => '',
        'lastname' => '',
        'gender' => '',
        'registered' => '0000-00-00 00:00:00',
        'admin' => 0,
        'lang' => '',
        'photo' => '',
        'email_verified' => 0,
        'slug' => ''
    ];

    /**
     * Initialisation d'un membre
     */
    public function         __init() {
        if ($this->get('registered') == '0000-00-00 00:00:00') {
            $this->set('registered', \Core\Db::date());
        }
    }

    /**
     * A la sauvegarde, générer le slug
     */
    public function         __beforeSave() {
        if ($this->get('slug') == '') {
            $suffix = false;
            $base = \Core\Text::slug($this->getName());
            $slug = $base;
            $check = true;
            $req = [];
            if ($this->id)
                $req['id'] = [
                    '$ne' => $this->id
                ];
            while ($check) {
                $slug = $base . ($suffix ? '-' . $suffix : '');
                $req['slug'] = $slug;
                $check = self::findOne($req);
                if (!$check) {
                    $suffix = $suffix === false ? 2 : $suffix + 1;
                }
            }
            $this->set('slug', $slug);
        }
    }

    /**
     * Tente de connecter un utilisateur
     *
     * @param string $email         Email
     * @param string $password      Mot de passe
     *
     * @return bool                 TRUE si l'utilisateur a été connecté, sinon FALSE
     */
    public static function  login($email, $password) {
        $user = self::findOne([
            'email' => $email
        ]);
        if (!$user)
            return false;

        if (\Core\Hash::same($password, $user->get('password'))) {
            $d = $user->export();
            \Core\Session::set('user', $d);
        }

        return true;
    }

    /**
     * Change le mot de passe d'un utilisateur
     *
     * @param string $newPassword       Nouveau mot de passe
     */
    public function         setPassword($newPassword) {
        $this->set('password', \Core\Hash::blowfish($newPassword));
    }

    /**
     * Met à jour l'avatar
     *
     * @param string $content       Contenu de l'image
     * @param bool $isBase64        Définit si le contenu de l'image est fourni en base64 ou non
     */
    public function         setLogo($content, $isBase64 = true) {
        if (!$isBase64)
            $content = base64_encode($content);
        $this->set('image', $content);
    }

    /**
     * Retourne le nom de l'utilisateur
     *
     * @return string
     */
    public function         getName() {
        return $this->get('firstname') . ' ' . $this->get('lastname');
    }
}