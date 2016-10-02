<?php

namespace Starter;

use Starter\App\Proxy as App;
use Starter\Messages\Error;
use Starter\Messages\Success;
use Starter\Utils\CString;
use Starter\Utils\Url;

class Template extends File {

    /** @var bool */
    private $rendered;

    /**
     * @param string $file
     */
    public function __construct ($file) {
        parent::__construct ($file . App::instance ()->settingsCore ()->template ('type'));
        $this->rendered = false;
    } // __construct ();

    /**
     * @param array $vars
     * @return string
     * @throws \Exception
     */
    public function render ($vars = array ()) {
        $out = '';
        if (!$this->rendered) {
            $this->rendered = true;
            if ($this->canRequire ()) {
                App::instance ()->debbug ()->add ("Chargement du template '{$this->getFile ()}'"
                    . " [mime:{$this->fileMime ()}]");
                ob_start ();
                    extract ($vars);
                    unset ($vars);
                    require $this->getFile ();
                    $out = ob_get_contents ();
                ob_end_clean ();
            } else {
                throw new \Exception ("Impossible de charger le template '{$this->getFile ()}'");
            }
        } else {
            App::instance ()->debbug ()->addNotice ("Instance de template '{$this->getFile ()}' déjà rendue");
        }
        return $out;
    } // render ();

    /**
     * @param string $path
     * @param array $vars
     * @return string
     */
    public function renderTemplate ($path, $vars = array ()) {
        $result = '';
        try {
            $object = new self (Path::design ($path));
            $result = $object->render ($vars);
        } catch (\Exception $e) {
            App::instance ()->debbug ()->addError ($e->getMessage ());
        }
        return $result;
    } // renderTemplate ();

    /**
     * @return Layout
     */
    public function layout () {
        return App::instance ()->layout ();
    } // layout ();

    /**
     * @return Design
     */
    public function design () {
        return App::instance ()->settingsDesign ();
    } // design ();

    /**
     * @param string $file
     * @return string
     */
    public function jsUrl ($file) {
        return Url::urlByType ('javascripts', $file);
    } // jsUrl ();

    /**
     * @param string $file
     * @return string
     */
    public function cssUrl ($file) {
        return Url::urlByType ('stylesheets', $file);
    } // cssUrl ();

    /**
     * @param string $file
     * @return string
     */
    public function imageUrl ($file) {
        return Url::urlByType ('images', $file);
    } // imageUrl ();

    /**
     * @param array|string $attributes
     * @return ResourceAttributes
     */
    public function renderAttr ($attributes) {
        return new ResourceAttributes ($attributes);
    } // renderAttr();

    /**
     * @param boolean|true $clear
     * @return array
     */
    public function errorMessages ($clear = true) {
        return Error::instance ()->get ($clear);
    } // errorMessages ();

    /**
     * @return boolean
     */
    public function hasErrorMessages () {
        return count ($this->errorMessages (false)) > 0;
    } // hasErrorMessages ();

    /**
     * @param boolean|true $clear
     * @return array
     */
    public function successMessages ($clear = true) {
        return Success::instance ()->get ($clear);
    } // successMessages ();

    /**
     * @return boolean
     */
    public function hasSuccessMessages () {
        return count ($this->successMessages (false)) > 0;
    } // hasSuccessMessages ();

    /**
     * @param string $string
     * @return array|string
     */
    public function escape ($string) {
        return CString::escapeHtml ($string);
    } // escape ();

    /**
     * @param string $var
     * @return mixed|null
     */
    public function __get ($var) {
        return App::instance ()->getVar ($var);
    } // __get ();

    /**
     * @param string $var
     * @param mixed $val
     */
    public function __set ($var, $val) {
        App::instance ()->setVar ($var, $val);
    } // __set ();

    /**
     * @param string $var
     * @return boolean
     */
    public function __isset ($var) {
        return App::instance ()->issetVar ($var);
    } // __isset ();

    /**
     * @return string
     * @throws \Exception
     */
    public function __toString () {
        return $this->render ();
    } // __toString ();

}; // Template;