<?php

namespace Starter;

class File {

    /** @var string */
    private $file;

    /** @var array */
    private $authRequireFiles = array (
        'php' => array ('text/x-php'),
        'phtml' => array ('text/plain', 'text/html', 'text/x-php')
    );

    /**
     * @param string $file
     */
    public function __construct ($file) {
        $this->file = $file;
        if ($this->fileExists ()) {
            $this->file = realpath ($file); // Nettoyage.
        }
    } // __construct ();

    /**
     * @return string
     */
    public function getFile () {
        return $this->file;
    } // getFile ();

    /**
     * @return array
     */
    public function getAuthRequireFiles () {
        return $this->authRequireFiles;
    } // getAuthRequireFiles ();

    /**
     * @return boolean
     */
    public function isAuthFileRequire () {
        return $this->fileExists ()
            && array_key_exists ($ext = $this->fileExtension (), $authFiles = $this->getAuthRequireFiles ())
            && ($mime = $this->fileMime ()) !== null
            && in_array ($mime, array_values ($authFiles[$ext]));
    } // isAuthFileRequire ();

    /**
     * Alias de isAuthRequireFile
     * @return boolean
     */
    public function canRequire () {
        return $this->isAuthFileRequire ();
    } // canRequire ();

    /**
     * @param string $type
     * @return boolean
     */
    public function isA ($type) {
        return ($ext = $this->fileExtension ()) === strtolower (trim ($type))
            && ($mime = $this->fileMime ()) !== null
            && in_array ($mime, array_values ($this->getAuthRequireFiles ()[$ext]));
    } // isA ();

    /**
     * @return bool
     */
    public function isPHP () {
        return $this->isA ('php');
    } // isPHP ();

    /**
     * @return string
     */
    public function basename () {
        return basename ($this->getFile (), '.' . $this->fileExtension ());
    } // basename ();

    /**
     * @return boolean
     */
    public function fileExists () {
        return self::exists ($this->getFile ());
    } // fileExists ();

    /**
     * @return string
     */
    public function fileExtension () {
        return self::extension ($this->getFile ());
    } // fileExtension ();

    /**
     * @return null|string
     */
    public function fileMime () {
        return self::mime ($this->getFile ());
    } // fileMime ();

    /**
     * @return null|string
     */
    public function fileContents () {
        return self::contents ($this->getFile ());
    } // fileContents ();

    /**
     * Doit être un véritable fichier, doit exister et avoir
     * suffisement de droits pour être utilisé par PHP.
     * @param string $file
     * @return boolean
     */
    public static function exists ($file) {
        return is_file ($file) && file_exists ($file);
    } // exists ();

    /**
     * Retourne l'extension d'un fichier en basant le résultat sur la chaine
     * passée en paramètre. Cette méthode n'utilise aucune fonction de typage
     * sur les fichiers.
     * @param string $file
     * @return string
     */
    public static function extension ($file) {
        return strtolower (substr (strrchr ($file, '.'), 1));
    } // extension ();

    /**
     * @param $file
     * @return null|string
     */
    public static function mime ($file) {
        $result = null;
        if (self::exists ($file)) {
            if (function_exists ('finfo_file')) {
                $finfo = new \finfo (FILEINFO_MIME);
                $result = ($infos = $finfo->file ($file)) !== false ? $infos : null;
                if ($result !== null) {
                    $result = explode (';', $result)[0];
                }
            } else {
                $result = ($mime = @mime_content_type ($file)) !== false ? $mime : null;
            }
        }
        return $result;
    } // mime ();

    /**
     * @param $file
     * @return null|string
     */
    public static function contents ($file) {
        return self::exists ($file) && ($content = @file_get_contents ($file)) !== false ? $content : null;
    } // contents ();

}; // File;