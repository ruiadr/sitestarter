<?php

namespace controllers;

use Starter\Controller\Base;

class MyController extends Base {

    /**
     * @param int $id
     * @return string
     */
    public function testAction ($id) {
        $this->layout ()->set ('my/test');
        return $this->renderPage ('my/test', array ('id' => $id, 'activeMenu' => 'my/test'));
    } // testAction ();

    /**
     * @param int $id
     * @return string
     */
    public function test2Action ($id) {
        $this->layout ()->set ('my/test');
        return $this->renderPage ('my/test2', array (
            'id' => $id,
            'globals' => array ('activeMenu' => 'my/test2')
        ));
    } // testAction ();

    /**
     * @param int $id
     */
    public function saveAction ($id) {
        if ($this->hasParam ('identifiant')
                && is_numeric ($identifiant = $this->getParam ('identifiant'))
                && $identifiant > 0) {
            $this->successMessage ("L'action s'est terminée correctement !");
            $this->redirect ('/my/test/' . $identifiant);
        } else {
            $this->errorMessage ("Le formulaire attend une valeur numérique strictement supérieure à 0 !");
            $this->redirect ('/my/test/' . $id);
        }
    } // saveAction ();

}; // MyController ();