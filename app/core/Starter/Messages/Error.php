<?php

namespace Starter\Messages;

class Error extends Base {

    const TYPE_KEY = 'error_messages';

    /** @var Error */
    private static $instance;

    private function __construct () {
    } // __construct ();

    private function __clone () {}

    /**
     * @return string
     */
    protected function getKey () {
        return self::TYPE_KEY;
    } // getKey ();

    /**
     * @return Error
     */
    public static function instance () {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self ();
        }
        return self::$instance;
    } // instance ();

}; // Success;