<?php

namespace Starter;

class Debbug {

    /** @var array */
    private $messages;

    public function __construct () {
        $this->messages = [];
    } // __construct ();

    /**
     * @param string $message
     * @return $this
     */
    public function add ($message) {
        $this->messages[] = array ('message', $message);
        return $this;
    } // add ();

    public function addNotice ($notice) {
        $this->messages[] = array ('notice', $notice);
        return $this;
    } // addNotice ();

    public function addError ($error) {
        $this->messages[] = array ('error', $error);
        return $this;
    } // addError ();

    /**
     * @return array
     */
    public function all () {
        return $this->messages;
    } // all ();

    /**
     * @return string
     */
    public function __toString () {
        $result  = '<div id="debbug">';
        $result .= '<h1>Debbug (' . count ($this->all ()) . ')</h1>';
        $result .= '<p>';

        $index = 1;
        foreach ($this->all () as $message) {
            $type = ucfirst ($message[0]);
            $result .= "<span class=\"{$message[0]}\"><strong>$index. [$type]:</strong> {$message[1]}</span>";
            ++$index;
        }

        $result .= '</p>';
        $result .= '</div>';

        return $result;
    } // __toString ();

}; // Debbug;