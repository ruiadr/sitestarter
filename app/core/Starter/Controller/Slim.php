<?php

namespace Starter\Controller;

use Interop\Container\ContainerInterface;
use Starter\App\Proxy as App;

class Slim {

    /**
     * @var ContainerInterface
     */
    protected $ci;

    /**
     * Slim constructor.
     * @param ContainerInterface $ci
     */
    public function __construct (ContainerInterface $ci) {
        $this->ci = $ci;
    } // __construct ();

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param array $args
     * @return mixed
     */
    public function actions ($request, $response, $args) {
        $actionController = App::instance ()->controller ()
            ->getActionController ($request->getAttribute ('route')->getPattern ());

        // $actionController ne peut pas être null à ce stade du code, Slim n'a
        // normalement pas trouvé la route associée au pattern, et a levé
        // une erreur. On réalise malgrès tout le test pour éviter de
        // générer une erreur fatale.
        if ($actionController !== null) {
            // [0] = class
            // [1] = method
            $information = explode (':', $actionController);

            /** @var Base $class */
            $class = new $information[0] ();

            // Paramètres GET et POST.
            $params = array ();
            if (is_array ($postParams = $request->getParsedBody ())) {
                $params = array_merge ($params, $postParams);
            }
            if (is_array ($getParams = $request->getQueryParams ())) {
                $params = array_merge ($params, $getParams);
            }
            $class->setParams ($params);

            $response->write (call_user_func_array (array ($class, $information[1]), $args));

            if (($redirect = $class->getRedirect ()) !== null) {
                return $response->withRedirect ($redirect);
            }
        }

        return $response;
    } // actions ();

}; // Slim;