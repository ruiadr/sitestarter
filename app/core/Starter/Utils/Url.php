<?php

namespace Starter\Utils;

use Starter\App\Proxy as App;
use Starter\Path;

class Url {

    /**
     * @param string $type
     * @param string $file
     * @return string
     */
    public static function urlByType ($type, $file) {
        $result = $file;
        if (self::isUrl ($file)) {
            $result = $file;
        } else if (is_string ($file) && is_string ($type)) {
            if (($path = App::instance ()->settingsCore ()->web ($type)) !== null) {
                $result = Path::clean ("/$path/$file", '/');
            } else {
                App::instance ()->debbug ()->addError ("Impossible d'accèder à la ressource '$file' de type '$type'");
            }
        } else {
            App::instance ()->debbug ()->addError (
                'Url::urlByType les paramètres $file && $type'
                . ' doivent être des chaines de caractères'
            );
        }
        return $result;
    } // urlByType ();

    /**
     * @param string $str
     * @return boolean
     */
    public static function isUrl ($str) {
        return filter_var ($str, FILTER_VALIDATE_URL);
    } // isUrl();

}; // Url;