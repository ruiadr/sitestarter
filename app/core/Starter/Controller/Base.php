<?php

namespace Starter\Controller;

use Starter\App\Proxy as App;
use Starter\Messages\Success;
use Starter\Messages\Error;

class Base {

    /** @var string */
    private $redirect;

    /** @var array */
    private $params;

    /**
     * @return \Starter\Debbug
     */
    public function layout () {
        return App::instance ()->layout ();
    } // layout ();

    /**
     * @param string $url
     */
    public function redirect ($url) {
        if (is_string ($url)) {
            $this->redirect = $url;
        }
    } // redirect ();

    /**
     * @return null|string
     */
    public function getRedirect () {
        return $this->redirect;
    } // getRedirect ();

    /**
     * @return array
     */
    public function getParams () {
        if ($this->params === null) {
            $this->params = array ();
        }
        return $this->params;
    } // getParams ();

    /**
     * @param string $key
     * @param null|mixed $default
     * @return null|mixed
     */
    public function getParam ($key, $default = null) {
        return is_string ($key) && array_key_exists ($key, $params = $this->getParams ())
            ? $params[$key] : $default;
    } // getParam ();

    /**
     * @param string $key
     * @return bool
     */
    public function hasParam ($key) {
        return $this->getParam ($key) !== null;
    } // hasParam ();

    /**
     * @param array $params
     * @return $this
     */
    public function setParams ($params) {
        if (is_array ($params)) {
            $this->params = $params;
        }
        return $this;
    } // setParams ();

    /**
     * @param string $message
     * @return $this
     */
    public function successMessage ($message) {
        Success::instance ()->add ($message);
        return $this;
    } // successMessage ();

    /**
     * @param string $message
     * @return $this
     */
    public function errorMessage ($message) {
        Error::instance ()->add ($message);
        return $this;
    } // errorMessage ();

    /**
     * @param string $page
     * @param array $args
     * @return string
     * @throws \Exception
     */
    protected function renderPage ($page, $args = array ()) {
        return App::instance ()->renderPage ($page, $args);
    } // renderPage ();

}; // Base;