<?php

namespace Starter\App;

use Slim as SlimApp;

class Slim extends Base {

    /** @var SlimApp\App */
    private $app;

    public function __construct () {
        parent::__construct ();
        $this->app = new SlimApp\App ();
    } // __construct ();

    /**
     * @param SlimApp\Http\Response $response
     * @return SlimApp\Http\Response
     */
    private function writeError ($response) {
        return $response
            ->withStatus (404)
            ->withHeader ('Content-Type', 'text/html')
            ->write (
                $this->render ($this->settingsCore ()->template ('error'), false)
            );
    } // writeError ();

    protected function execute () {
        $ref = $this;

        // Gestion des routes.

        $this->app->get ('/', function ($request, $response, $args) use ($ref) {
            // Si le template de la homepage n'a pas été trouvé, on laisse le
            // système générer une erreur 500.
            return $response->write ($ref->render (
                $ref->settingsCore ()->template ('homepage'), false
            ));
        });

        $this->app->get ('/{key}', function ($request, $response, $args) use ($ref) {
            try {
                // Si la page n'a pas été trouvée le système génère une erreur 500 car
                // une exception est levée. Il faut lui indiquer de générer une 404.
                $response->write ($ref->render ($args['key']));
            } catch (\Exception $e) {
                $ref->debbug ()->addError ($e->getMessage ());
                $response = $ref->writeError ($response);
            }
            return $response;
        });

        $this->app->add (function ($request, $response, $next) use ($ref) {
            $response = $next ($request, $response);
            if ($ref->settingsSite ()->debbugEnabled ()) {
                $response->getBody ()->write ($ref->debbug ());
            }
            return $response;
        });

        // Gestion des erreurs.

        $this->app->getContainer ()['notFoundHandler'] = function ($c) {
            return function ($request, $response) use ($c) {
                return $this->writeError ($c['response']);
            };
        };

        $this->app->getContainer ()['errorHandler'] = function ($c) {
            return function ($request, $response, $exception) use ($c) {
                $this->debbug ()->addError ($exception->getMessage ());
                return $c['response']
                    ->withStatus (500)
                    ->withHeader ('Content-Type', 'text/html')
                    ->write (
                        'Il y a eu une erreur, merci de réessayer ultérieurement' .
                        ($this->settingsSite ()->debbugEnabled () ? $this->debbug () : '')
                    );
            };
        };

        // Les controleurs.

        foreach ($this->controller ()->getControllersRoute () as $key => $value) {
            $this->app->map (['GET', 'POST'], $key, 'Starter\\Controller\\Slim:actions');
        }

        // Suppression du "/" final dans le pattern des routes.
        // Redirection 301.

        $this->app->add (function ($request, $response, $next) {
            $uri = $request->getUri ();
            $path = $uri->getPath ();
            if ($path !== '/' && substr ($path, -1) === '/') {
                $uri = $uri->withPath (substr ($path, 0, -1));
                return $response->withRedirect ((string)$uri, 301);
            }
            return $next ($request, $response);
        });

        // Lancement de l'application.

        $this->app->run ();
    } // execute ();

}; // Slim;