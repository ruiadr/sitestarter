<?php

namespace Starter\Messages;

class Success extends Base {

    const TYPE_KEY = 'success_messages';

    /** @var Success */
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
     * @return Success
     */
    public static function instance () {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self ();
        }
        return self::$instance;
    } // instance ();

}; // Success;