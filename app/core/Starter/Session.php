<?php

namespace Starter;

class Session {

    /**
     * @param string $key
     * @param null $default
     * @return null|mixed
     */
    public function get ($key, $default = null) {
        return is_string ($key) && $this->exists ($key) ? $_SESSION[$key] : $default;
    } // get ();

    /**
     * @param string $key
     * @return boolean
     */
    public function has ($key) {
        return $this->get ($key) !== null;
    } // has ();

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function set ($key, $value) {
        if (is_string ($key)) {
            $_SESSION[$key] = $value;
        }
        return $this;
    } // set ();

    /**
     * @param string $key
     * @return $this
     */
    public function delete ($key) {
        if ($this->exists ($key)) {
            unset ($_SESSION[$key]);
        }
        return $this;
    } // delete ();

    /**
     * @return $this
     */
    public function clear () {
        $_SESSION = array ();
        return $this;
    } // clear ();

    /**
     * @param string $key
     * @return boolean
     */
    protected function exists ($key) {
        return is_string ($key) && array_key_exists ($key, $_SESSION);
    } // $key ();

    /**
     * @param string $key
     * @return mixed
     */
    public function __get ($key) {
        return $this->get ($key);
    } // __get ();

    /**
     * @param string $key
     * @param mixed $value
     */
    public function __set ($key, $value) {
        $this->set ($key, $value);
    } // __set ();

    /**
     * @param string $key
     */
    public function __unset ($key) {
        $this->delete ($key);
    } // __unset ();

    /**
     * @param string $key
     * @return boolean
     */
    public function __isset ($key) {
        return $this->exists ($key);
    } // __isset ();

}; // Session;