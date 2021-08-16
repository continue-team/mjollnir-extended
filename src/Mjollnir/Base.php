<?php

namespace Mjollnir;

class Base {

    public $_url = false;

    public function __construct() {
        if (\getenv("MJOLLNIR_URL") === null || empty(\getenv("MJOLLNIR_URL"))) throw new \Exception('Wrong configuration');;
        $this->_url = \getenv("MJOLLNIR_URL");
    }

    public function validate($request) {

        return true;
    }
}