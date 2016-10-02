<?php

namespace Starter\Settings;

use Starter\Path;

class Site extends Base {

    const FILE = 'settings.yml';

    public function __construct () {
        parent::__construct (Path::app (self::FILE));
    } // __construct ();

    /**
     * @return array
     */
    protected function defaultContent () {
        return array (
            'debbug' => array (
                'enabled' => false
            )
        );
    } // defaultContent ();

    /**
     * @return boolean
     */
    public function debbugEnabled () {
        return $this->get ('debbug', 'enabled', false);
    } // debbugEnabled ();

}; // Site;