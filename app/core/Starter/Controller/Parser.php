<?php

namespace Starter\Controller;

use Starter\App\Proxy as App;
use Starter\File;
use Starter\Path;

class Parser {

    /** @var array */
    private $controllersRoute;

    public function __construct () {
        $this->buildList ();
    } // __construct ();

    /**
     * @return array
     */
    public function getControllersRoute () {
        if ($this->controllersRoute === null) {
            $this->controllersRoute = [];
        }
        return $this->controllersRoute;
    } // getControllersRoute ();

    /**
     * @param string $route
     * @return null|string
     */
    public function getActionController ($route) {
        return is_string ($route) && array_key_exists ($route, $this->getControllersRoute ())
            ? $this->getControllersRoute ()[$route]
            : null;
    } // getActionController ();

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    private function addRoute ($key, $value) {
        $collection = $this->getControllersRoute ();
        $collection[$key] = $value;
        $this->controllersRoute = $collection;
        return $this;
    } // addRoute ();

    private function buildList () {
        $dirName = App::instance ()->settingsCore ()->path ('controllers');
        foreach (scandir ($dir = Path::app ($dirName)) as $filename) {
            $file = new File ($dir . DS . $filename);
            if ($file->isPHP ()) {
                $className = $dirName . '\\' . $file->basename ();
                if (class_exists ($className)) {
                    $this->appendController ($className);
                }
            }
        }
    } // buildList ();

    /**
     * @param string $controller
     */
    private function appendController ($controller) {
        if (is_string ($controller)) {
            if (get_parent_class ($controller) === 'Starter\Controller\Base') {
                $baseName = self::baseNameByClassName ($controller);
                foreach (get_class_methods ($controller) as $action) {
                    $matches = array ();
                    if (preg_match ('/^(.*)(?:Action)$/', $action, $matches) !== false
                            && is_array ($matches) && count ($matches) > 1)  {
                        // Inutile de tester la présence de cette route dans le tableau car
                        // ce cas ne peut techniquement pas se présenter.
                        $params = $this->parameters ($controller, $action);
                        $this->addRoute ("/$baseName/{$matches[1]}$params", "$controller:{$matches[0]}");
                    }
                }
            } else {
                App::instance ()->debbug ()->addError ("'$controller' n'est pas un controleur valide");
            }
        } else {
            App::instance ()->debbug ()->addError ("Il y a eu une erreur avec le chargement d'un controleur");
        }
    } // appendController ();

    /**
     * @param string $controller
     * @param string $action
     * @return string
     */
    private function parameters ($controller, $action) {
        $result = '%';
        $reflection = new \ReflectionMethod ($controller, $action);
        if (!empty ($params = $reflection->getParameters ())) {
            foreach ($params as $param) {
                $key = '/{' . $param->getName () . '}';
                $result = str_replace ('%', $param->isOptional () ? "[$key%]" : "$key%", $result);
            }
        }
        $result = str_replace ('%', '', $result);
        return $result;
    } // parameters ();

    /**
     * @param string $className
     * @return string
     */
    public static function baseNameByClassName ($className) {
        // Transforme quelque chose de la forme: "controllers\MaClasseController" en "maclasse".
        return strtolower (
            str_replace (App::instance ()->settingsCore ()->key ('controller'), '',
                str_replace (App::instance ()->settingsCore ()->path ('controllers') . '\\', '', $className)
            )
        );
    } // baseNameByClassName ();

}; // Parser;