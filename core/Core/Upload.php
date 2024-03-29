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

namespace                           Core;

/**
 * Gère l'upload de fichiers vers le serveur.
 *
 * Class Upload
 * @package Core
 */
class 				                Upload {
    /** @var array $allowedExtensions Extensions de fichier autorisées. Si vide, toutes sont autorisées */
    private 		                $allowedExtensions = [];

    /** @var string $filename Nom du fichier */
    public	 		                $filename;

    /** @var string $extension Extension du fichier */
    public	 		                $extension;

    /** @var string $tmpName Nom temporaire */
    private 		                $tmpName;

    /** @var int $maxSize Taille maximale autorisée */
    private                         $maxSize;

    /** @var bool $uploaded Si TRUE, le fichier à bien été uploadé */
    public	 		                $uploaded;

    /** @var int $error Code d'erreur */
    public	 		                $error;

    /** @var int $size Taille du fichier */
    public 			                $size;

    /** @var string $uploadDir Dossier d'upload */
    public static 	                $uploadDir = '/uploads/';

    /**
     * Routine d'upload d'un fichier
     *
     * @param mixed $field          Champ du $_FILE, ou directement l'entrée du tableau.
     * @param bool $isData          Détermine si oui, ou non, la valeur dans $field est l'entrée du tableau.
     * @param array $extensions     Extensions autorisées. Si vide, toutes sont autorisées.
     *
     * @return bool|string          Retourne le chemin du fichier uploadé, sinon FALSE si l'upload a échoué.
     */
    public static function 	        job($field, $isData = false, $extensions = []) {
        Debug::trace();
        $u = new Upload($field, $isData);
        if ($u->error() != UPLOAD_ERR_OK)
            return false;
        $u->setMaxSize(80000000);
        $u->allowExtensions($extensions);

        $path = ROOT . self::$uploadDir;
        if (!is_dir($path))
            mkdir($path);
        $exists = true;
        while ($exists) {
            $exists = false;
            $newFilename = Text::slug(str_replace('.'.$u->extension, '', $u->filename)).'-'.Text::random(6, '0123456789aqwzsxedcrfvtgbyhnujikolpm').'.'.$u->extension;
            if (file_exists($path . $newFilename))
                $exists = true;
        }
        $uploaded = $u->register($path . $newFilename);
        if (!$uploaded)
            return false;
        return self::$uploadDir . $newFilename;
    }

    /**
     * Upload constructor.
     *
     * @param mixed $field          Champ du $_FILE, ou directement l'entrée du tableau.
     * @param bool $isData          Détermine si oui, ou non, la valeur dans $field est l'entrée du tableau.
     */
    public function 		        __construct($field, $isData = false) {
        Debug::trace();
        if (!$isData)
            $file = $_FILES[$field];
        else
            $file = $field;
        if ((!$isData && !isset($_FILES[$field])) || $file['error'] > 0) {
            $this->uploaded = false;
            $this->error = $file['error'];
        } else {
            $this->uploaded = true;
            $this->error = 0;
            $this->filename = $file['name'];
            // Getting file extension
            $ext = explode('.', $this->filename);
            $this->extension = strtolower($ext[sizeof($ext) - 1]);
            $this->maxSize = Ini::size(Ini::get('upload_max_filesize'));
            $this->tmpName = $file['tmp_name'];
            $this->size = $file['size'];
        }
    }

    /**
     * Autorise une extension
     *
     * @param string $ext           Extension
     */
    public function 		        allowExtension($ext) {
        Debug::trace();
        $this->allowedExtensions[] = $ext;
        $this->allowedExtensions = array_unique($this->allowedExtensions);
    }

    /**
     * Autorise plusieurs extensions
     *
     * @param array $arr            Liste des extensions
     */
    public function 		        allowExtensions($arr = []) {
        Debug::trace();
        $this->allowedExtensions = array_unique(array_merge($this->allowedExtensions, $arr));
    }

    /**
     * Fixe la valeur de la taille maximale autorisée.
     *
     * @param int $maxSize          Taille maximale autorisée
     */
    public function 		        setMaxSize($maxSize) {
        Debug::trace();
        $this->maxSize = $maxSize;
    }

    /**
     * Détermine si oui, ou non, le fichier a bien été uploadé.
     *
     * @return bool                 Détermine si oui, ou non, le fichier a bien été uploadé.
     */
    public function 		        uploaded() {
        Debug::trace();
        return $this->uploaded;
    }

    /**
     * Retourne le code d'erreur.
     *
     * @return int                  Code d'erreur
     */
    public function 		        error() {
        Debug::trace();
        return $this->error;
    }

    /**
     * Retourne un message d'erreur lié au code d'erreur.
     *
     * @return string               Message d'erreur.
     */
    public function 		        errorMsg() {
        Debug::trace();
        switch ($this->error) {
            case UPLOAD_ERR_OK:
                return '';
                break;
            case UPLOAD_ERR_INI_SIZE:
                return _t('Le fichier est trop lourd (ini).');
                break;
            case UPLOAD_ERR_FORM_SIZE:
                return _t('Le fichier est trop lourd.');
                break;
            case UPLOAD_ERR_PARTIAL:
                return _t('L\'upload a été interrompu.');
                break;
            case UPLOAD_ERR_NO_FILE:
                return _t('Aucun fichier n\'a été envoyé.');
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                return _t('Erreur d\'écriture dans le dossier temporaire.');
                break;
            case UPLOAD_ERR_CANT_WRITE:
                return _t('Erreur d\'écriture sur le disque.');
                break;
            case UPLOAD_ERR_EXTENSION:
                return _t('L\'extension n\'est pas autorisée.');
                break;
            default:
                return _t('Erreur inconnue.');
                break;
        }
    }

    /**
     * Retourne le nom du fichier.
     *
     * @return string               Nom du fichier
     */
    public function 		        filename() {
        Debug::trace();
        return $this->filename;
    }

    /**
     * Retourne la taille du fichier
     *
     * @return int                  Taille
     */
    public function 		        size() {
        Debug::trace();
        return $this->size;
    }

    /**
     * Retourne l'extension du fichier
     *
     * @return string               Extension
     */
    public function 		        extension() {
        Debug::trace();
        return $this->extension;
    }

    /**
     * Détermine si le fichier peut être uploadé ou pas.
     *
     * @return bool                 TRUE si le fichier peut être uploadé, sinon FALSE.
     */
    private function		        allowed() {
        Debug::trace();
        // Check size
        if ($this->size > $this->maxSize) {
            $this->error = UPLOAD_ERR_FORM_SIZE;
            return false;
        }
        if (sizeof($this->allowedExtensions) > 0 && !in_array($this->extension, $this->allowedExtensions)) {
            $this->error = UPLOAD_ERR_EXTENSION;
            return false;
        }
        return true;
    }

    /**
     * Retourne le contenu du fichier en base64.
     *
     * @return bool|string          Si le fichier peut être uploadé, retourne son contenu en base64, sinon FALSE.
     */
    public function 		        base64() {
        Debug::trace();
        if ($this->allowed())
            return base64_encode(file_get_contents($this->tmpName));
        return false;
    }

    /**
     * Enregistre le fichier dans le dossier de destination si il peut être uploadé.
     *
     * @param bool|string $filename     Chemin du fichier. Si FALSE, la fonction retournera le contenu du fichier.
     *
     * @return mixed                    Si le fichier ne peut être uploadé, retourne FALSE. Si $filename n'est pas fourni
     *                                  ou est à FALSE, retourne le contenu du fichier, sinon écrit le fichier dans le
     *                                  dossier de destination.
     */
    public function 		        register($filename = false) {
        Debug::trace();
        if (!$this->allowed())
            return false;
        if (!$filename)
            return file_get_contents($this->tmpName);
        move_uploaded_file($this->tmpName, $filename);
        $this->tmpName = $filename;
        return $filename;
    }
}