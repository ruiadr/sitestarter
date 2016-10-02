<?php

namespace Starter\Settings;

use Starter\App\Proxy as App;
use Starter\Path;

class Design extends Base {

    const FILE = 'design.yml';

    public function __construct () {
        parent::__construct (Path::app (self::FILE));
    } // __construct ();

    /**
     * @return array
     */
    protected function defaultContent () {
        App::instance ()->debbug ()->addNotice ('Fallback de settings : ' . self::FILE);
        return array (
            'head' => array (
                'css' => array (),
                'js'  => array ()
            ),
            'body' => array (
                'js'  => array ()
            )
        );
    } // defaultContent ();

    /**
     * @param string $section
     * @return null|mixed
     */
    public function getCss ($section) {
        return $this->get ($section, 'css', array ());
    } // getCss ();

    /**
     * @param string $section
     * @return null|mixed
     */
    public function getJs ($section) {
        return $this->get ($section, 'js', array ());
    } // getJs ();

    /**
     * @param string $section
     * @param string $value
     * @return $this
     */
    public function addCss ($section, $value) {
        $this->add ($section, 'css', $value);
        return $this;
    } // addCss ();

    /**
     * @param string $section
     * @param string $value
     * @return $this
     */
    public function addJs ($section, $value) {
        $this->add ($section, 'js', $value);
        return $this;
    } // addJs ();

}; // Design;