<?php

namespace Starter\App;

use Starter\Settings\Core as SettingsCore;
use Starter\Settings\Site as SettingsSite;
use Starter\Settings\Design as SettingsDesign;
use Starter\Controller\Parser;
use Starter\Debbug;
use Starter\Layout;
use Starter\Template;
use Starter\TemplateLayout;
use Starter\Path;

abstract class Base {

    /** @var SettingsCore */
    private $settingsCore;

    /** @var SettingsSite */
    private $settingsSite;

    /** @var SettingsDesign */
    private $settingsDesign;

    /** @var Debbug */
    private $debbug;

    /** @var Layout */
    private $layout;

    /** @var Parser */
    private $controller;

    /** @var array */
    private $vars;

    /** @var boolean */
    private $executed;

    public function __construct () {
        $this->vars = [];
        $this->executed = false;
    } // __construct ();

    /**
     * @return SettingsCore
     */
    public function settingsCore () {
        if ($this->settingsCore === null) {
            $this->settingsCore = new SettingsCore ();
        }
        return $this->settingsCore;
    } // settingsCore ();

    /**
     * @return SettingsSite
     */
    public function settingsSite () {
        if ($this->settingsSite === null) {
            $this->settingsSite = new SettingsSite ();
        }
        return $this->settingsSite;
    } // settingsSite ();

    /**
     * @return SettingsDesign
     */
    public function settingsDesign () {
        if ($this->settingsDesign === null) {
            $this->settingsDesign = new SettingsDesign ();
        }
        return $this->settingsDesign;
    } // settingsDesign ();

    /**
     * @return Debbug
     */
    public function debbug () {
        if ($this->debbug === null) {
            $this->debbug = new Debbug ();
        }
        return $this->debbug;
    } // debbug ();

    /**
     * @return Layout
     */
    public function layout () {
        if ($this->layout === null) {
            $this->layout = new Layout ();
        }
        return $this->layout;
    } // layout ();

    /**
     * @return Parser
     */
    public function controller () {
        if ($this->controller === null) {
            $this->controller = new Parser ();
        }
        return $this->controller;
    } // controller ();

    /**
     * @param string $page
     * @param array $args
     * @return string
     * @throws \Exception
     */
    public function renderPage ($page, $args = array ()) {
        // Rendu de la page.
        $tpl = new Template (Path::page ($page));

        // Variables à utiliser de manière globale!
        if (isset ($args['globals'])) {
            foreach ($args['globals'] as $key => $value) {
                $this->setVar ($key, $value);
            }
            unset ($args['globals']); // Il faut les supprimer.
        }

        $pageRender = $tpl->render ($args);

        // Rendu du layout.
        $layout = new TemplateLayout ($this->layout ()->get ());
        $layout->setContent ($pageRender);

        return $layout->render ();
    } // renderPage ();

    /**
     * Par défaut, le chargement manuel d'un template qui correspond à une page système (ex: page d'erreur)
     * n'est pas autorisé, pour outrepasser ce comportement, il suffit de passer $checkSys à false.
     * @param string $page
     * @param bool|true $checkSys
     * @param array $args
     * @return string
     * @throws \Exception
     */
    protected function render ($page, $checkSys = true, $args = array ()) {
        if ($checkSys && in_array ($page, array (
                $this->settingsCore ()->template ('error'),
                $this->settingsCore ()->template ('homepage')))) {
            throw new \Exception ("Le chargement manuel de la page '$page' est interdit");
        }
        return $this->renderPage ($page, $args);
    } // render ();

    /**
     * @param string $var
     * @param mixed $val
     * @return $this
     */
    public function setVar ($var, $val) {
        if (is_string ($var) && ($var = trim ($var)) !== '') {
            if ($this->issetVar ($var)) {
                $this->debbug ()->addError ("La variable '$var' existe déjà elle a été écrasée");
            }
            $this->vars[$var] = $val;
        }
        return $this;
    } // setVar ();

    /**
     * @param string $var
     * @return null|mixed
     */
    public function getVar ($var) {
        $result = null;
        if ($this->issetVar ($var)) {
            $result = $this->vars[$var];
        } else {
            $this->debbug ()->addError ("La variable '$var' n'existe pas");
        }
        return $result;
    } // getVar ();

    /**
     * @param string $var
     * @return boolean
     */
    public function issetVar ($var) {
        return is_string ($var) && ($var = trim ($var)) !== '' & isset ($this->vars[$var]);
    } // issetVar ();

    /**
     * @return $this
     */
    public function executeApp () {
        if ($this->executed === false) {
            if ($this->settingsSite ()->debbugEnabled ()) {
                $this->settingsDesign ()->addCss ('head', 'debbug.css');
            }
            $this->executed = true;
            session_start ();
            $this->execute ();
        }
        return $this;
    } // executeApp ();

    protected abstract function execute ();

}; // Base;