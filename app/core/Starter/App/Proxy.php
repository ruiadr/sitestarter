<?php

namespace Starter\App;

class Proxy {

    /** @var Proxy */
    private static $instance;

    /** @var Base */
    private $app;

    private function __construct () {
    } // __construct ();

    private function __clone () {}

    /**
     * @return Proxy
     */
    public static function instance () {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self ();
        }
        return self::$instance;
    } // instance ();

    /**
     * @param Base $app
     * @return $this
     * @throws \Exception
     */
    public function defineApp ($app) {
        if ($this->app === null) {
            if (!($app instanceof Base)) {
                throw new \Exception (get_class ($app) . " n'est pas une instance de 'Base'");
            }
            $this->app = $app;
        }
        return $this;
    } // defineApp ();

    /**
     * @return \Starter\Settings\Core
     */
    public function settingsCore () {
        return $this->app->settingsCore ();
    } // settingsCore ();

    /**
     * @return \Starter\Settings\Site
     */
    public function settingsSite () {
        return $this->app->settingsSite ();
    } // settingsSite ();

    /**
     * @return \Starter\Settings\Design
     */
    public function settingsDesign () {
        return $this->app->settingsDesign ();
    } // settingsDesign ();

    /**
     * @return \Starter\Debbug
     */
    public function debbug () {
        return $this->app->debbug ();
    } // debbug ();

    /**
     * @return \Starter\Debbug
     */
    public function layout () {
        return $this->app->layout ();
    } // layout ();

    /**
     * @return \Starter\Controller\Parser
     */
    public function controller () {
        return $this->app->controller ();
    } // layout ();

    /**
     * @return $this
     */
    public function executeApp () {
        $this->app->executeApp ();
        return $this;
    } // executeApp ();

    /**
     * @param string $page
     * @param array $args
     * @return string
     */
    public function renderPage ($page, $args = array ()) {
        return $this->app->renderPage ($page, $args);
    } // renderPage ();

    /**
     * @param string $var
     * @param mixed $val
     * @return $this
     */
    public function setVar ($var, $val) {
        $this->app->setVar ($var, $val);
        return $this;
    } // setVar ();

    /**
     * @param string $var
     * @return null|mixed
     */
    public function getVar ($var) {
        return $this->app->getVar ($var);
    } // getVar ();

    /**
     * @param string $var
     * @return boolean
     */
    public function issetVar ($var) {
        return $this->app->issetVar ($var);
    } // issetVar ();

}; // Proxy;