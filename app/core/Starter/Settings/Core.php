<?php

namespace Starter\Settings;

class Core extends Base {

    const FILE = 'settings.yml';

    public function __construct () {
        parent::__construct (dirname (dirname (dirname (__FILE__))) . DS . self::FILE);
    } // __construct ();

    /**
     * @param string $key
     * @return null|string
     */
    public function layout ($key) {
        return $this->get ('layout', $key);
    } // layout ();

    /**
     * @param string $key
     * @return null|string
     */
    public function template ($key) {
        return $this->get ('template', $key);
    } // template ();

    /**
     * @param string $key
     * @return null|string
     */
    public function path ($key) {
        return $this->get ('path', $key);
    } // path ();

    /**
     * @param string $key
     * @return null|string
     */
    public function web ($key) {
        return $this->get ('web', $key);
    } // path ();

    /**
     * @param string $key
     * @return null|string
     */
    public function key ($key) {
        return $this->get ('key', $key);
    } // path ();

}; // Core;