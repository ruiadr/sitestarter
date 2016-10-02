<?php

namespace Starter;

use Starter\App\Proxy as App;

class Layout {

    /** @var string */
    private $tpl;

    /**
     * @return string
     */
    public function get () {
        if ($this->tpl === null) {
            $this->tpl = Path::layout (App::instance ()->settingsCore ()->layout ('default'));
        }
        return $this->tpl;
    } // get ();

    /**
     * @param string $tpl
     * @return $this
     */
    public function set ($tpl) {
        $destinationFile = ($tpl = Path::layout ($tpl))
            . App::instance ()->settingsCore ()->template ('type');

        if (File::exists ($destinationFile)) {
            $this->tpl = $tpl;
        } else {
            App::instance ()->debbug ()->addErro ("Le fichier de layout '$destinationFile'"
                . " n'existe pas, fallback sur le fichier par défaut");
        }

        return $this;
    } // set ();

}; // Layout;