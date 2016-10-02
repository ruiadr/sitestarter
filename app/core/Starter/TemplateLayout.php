<?php

namespace Starter;

class TemplateLayout extends Template {

    /** @var string */
    private $content;

    /**
     * @param string $path
     */
    public function __construct ($path) {
        parent::__construct ($path);
        $this->content = '';
    } // __construct ();

    /**
     * @param string $content
     * @return $this
     */
    public function setContent ($content) {
        $this->content = $content;
        return $this;
    } // setContent ();

    /**
     * @return string
     */
    public function getContent () {
        return $this->content;
    } // getContent ();

}; // TemplateLayout;