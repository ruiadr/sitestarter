<?php

namespace Starter;

use Starter\App\Proxy as App;
use Starter\Utils\Url;

class ResourceAttributes {

    /** @var array */
    private $attributes;

    /** @var array */
    private $urlAttributes;

    /** @var array */
    private $mapPath;

    /**
     * @param array|string $attributes
     */
    public function __construct ($attributes) {
        if (is_array ($attributes)) {
            $this->attributes = $attributes;
        } else if (is_string ($attributes)
                && array_key_exists ($ext = File::extension ($attributes), $this->urlAttributes ())) {
            $this->attributes = array ($this->urlAttributes ()[$ext] => $attributes);
        } else {
            $this->attributes = array ();
        }
    } // __construct ();

    /**
     * @return array
     */
    public function urlAttributes () {
        if ($this->urlAttributes === null) {
            $this->urlAttributes = array ('css' => 'href', 'js' => 'src');
        }
        return $this->urlAttributes;
    } // urlAttributes ();

    /**
     * @return array
     */
    public function mapPath () {
        if ($this->mapPath === null) {
            $this->mapPath = array ('css' => 'stylesheets', 'js' => 'javascripts');
        }
        return $this->mapPath;
    } // mapPath ();

    /**
     * @param string $name
     * @return boolean
     */
    public function isUrlAttribute ($name) {
        return in_array ($name, array_values ($this->urlAttributes ()));
    } // isUrlAttribute ();

    /**
     * @param string $file
     * @return string
     */
    public function getPath ($file) {
        if (array_key_exists ($ext = File::extension ($file), $this->mapPath ())) {
            $result = Url::urlByType ($this->mapPath ()[$ext], $file);
        } else {
            App::instance ()->debbug ()->addError ("Impossible de déterminer le path du fichier '$file'");
            $result = $file;
        }
        return $result;
    } // getPath ();

    /**
     * @return string
     */
    public function __toString () {
        $result = array ();
        foreach ($this->attributes as $name => $value) {
            $result[] = $name . '="' . ($this->isUrlAttribute ($name) ? $this->getPath ($value) : $value) . '"';
        }
        return ' ' . implode (' ', $result);
    } // __toString ();

}; // ResourceAttributes;