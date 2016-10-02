<?php

namespace Starter;

use Starter\App\Proxy as App;

class Path {

    /**
     * @param string $key
     * @return mixed
     */
    private static function settingsValue ($key) {
        return App::instance ()->settingsCore ()->path ($key);
    } // settingsValue ();

    /**
     * Nettoie la chaine $path passée en paramètre.
     * @param string $path
     * @param string $separator
     * @return string
     */
    public static function clean ($path, $separator = DS) {
        $path = preg_replace ('/\\' . $separator . '+/', $separator, trim ($path));
        $matches = array ();
        if (preg_match_all ('/([[:alnum:]][[:alnum:]_\-\/\.\\\]*)/', $path, $matches) !== false
                && is_array ($matches)
                && count ($matches) > 0
                && count ($matches[0]) > 0) {
            $path = $matches[0][0];
        }
        return "$separator$path";
    } // clean ();

    /**
     * @param string $file
     * @return string
     */
    public static function root ($file) {
        return self::clean (ROOT . DS . trim ($file));
    } // root ();

    /**
     * @param string $file
     * @return string
     */
    public static function app ($file) {
        return self::clean (self::root (self::settingsValue ('app') . DS . $file));
    } // app ();

    /**
     * @param string $file
     * @return string
     */
    public static function design ($file) {
        return self::clean (self::app (self::settingsValue ('design') . DS . $file));
    } // design ();

    /**
     * @param string $file
     * @return string
     */
    public static function layout ($file) {
        return self::clean (self::design (self::settingsValue ('layouts') . DS . $file));
    } // layout ();

    /**
     * @param string $file
     * @return string
     */
    public static function page ($file) {
        return self::clean (self::design (self::settingsValue ('pages') . DS . $file));
    } // page ();

}; // Path;