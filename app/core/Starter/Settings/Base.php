<?php

namespace Starter\Settings;

use Symfony\Component\Yaml\Yaml;

use Starter\App\Proxy as App;
use Starter\Utils\Arrays;
use Starter\File;

class Base extends File {

    /** @var mixed */
    private $settings;

    /**
     * @param string $file
     */
    public function __construct ($file) {
        parent::__construct ($file);
    } // __construct ();

    /**
     * @return mixed
     */
    public function content () {
        if ($this->settings === null) {
            App::instance ()->debbug ()->add ("Chargement du fichier de settings '{$this->getFile ()}'");
            if ($this->fileExists () && ($contents = $this->fileContents ()) !== null) {
                $this->settings = Yaml::parse ($contents);
            } else {
                App::instance ()->debbug ()->addError (
                    "Le fichier de settings '{$this->getFile ()}'"
                        . " n'existe pas ou n'a pas pu être lu"
                );
                $this->settings = $this->defaultContent ();
            }
        }
        return $this->settings;
    } // content ();

    /**
     * Fallback de settings appelé en cas de problème de chargement
     * des fichiers de settings.
     * @return array
     */
    protected function defaultContent () {
        return array ();
    } // defaultContent ();

    /**
     * @param string $section
     * @param array $default
     * @return array
     */
    public function getSection ($section, $default = array ()) {
        $return = $default;
        if (is_string ($section) && array_key_exists ($section, $this->content ())) {
            if (($result = $this->content ()[$section]) !== null) {
                $return = $result;
            }
        }
        return $return;
    } // getSection ();

    /**
     * @param string $section
     * @param string $key
     * @param null|mixed $default
     * @return null|mixed
     */
    public function get ($section, $key, $default = null) {
        $return = $default;
        if (is_string ($section)
                && is_string ($key)
                && array_key_exists ($section, $this->content ())
                && array_key_exists ($key, $this->content ()[$section])) {
            if (($result = $this->content ()[$section][$key]) !== null) {
                $return = $result;
            }
        }
        return $return;
    } // get ();

    /**
     * @param string $section
     * @param string $type
     * @param string $value
     * @return $this
     */
    public function add ($section, $type, $value) {
        if (($content = $this->get ($section, $type)) !== null
                && is_string ($section) && is_string ($type)) {
            if (!in_array ($value, $content)) {
                $this->settings[$section][$type][] = $value;
                if (is_array ($value)) {
                    $value = Arrays::implodeAssoc ($value);
                }
                App::instance ()->debbug ()->add ("Ajout de l'entrée [$section:$type:$value]");
            } else {
                if (is_array ($value)) {
                    $value = Arrays::implodeAssoc ($value);
                }
                App::instance ()->debbug ()->addNotice ("L'entrée [$section:$type:$value] existe déjà");
            }
        }
        return $this;
    } // add ();

}; // Base;