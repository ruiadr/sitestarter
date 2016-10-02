<?php

namespace Starter\Messages;

use Starter\Session;

abstract class Base {

    /** @var Session */
    private $session;

    /**
     * @return Session
     */
    private function session () {
        if ($this->session === null) {
            $this->session = new Session ();
        }
        return $this->session;
    } // session ();

    /**
     * @param boolean|false $clear
     * @return array
     */
    public function get ($clear = false) {
        $session = $this->session ();
        if (!$session->has ($key = $this->getKey ())) {
            $session->set ($key, array ());
        }
        $result = $session->get ($key);
        if ($clear) {
            $session->delete ($key);
        }
        return $result;
    } // get ();

    /**
     * @param string $message
     * @return $this
     */
    public function add ($message) {
        if (is_string ($message)) {
            $this->session ()->set (
                $this->getKey (), array_merge ($this->get (), array ($message))
            );
        }
        return $this;
    } // add ();

    abstract protected function getKey ();

}; // Base;