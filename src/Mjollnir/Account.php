<?php

namespace Mjollnir;

class Account extends Request
{

    public function register() {
        if (!$this->_data) return false;
        if (empty($this->_data) || !(array)$this->_data) $this->_data = new \stdClass();
        $this->_data = json_encode($this->_data);

        $response = parent::curl("register", $this->_data);

        return $response;
    }

    public function login() {
        if (!$this->_data) return false;
        if (empty($this->_data) || !(array)$this->_data) $this->_data = new \stdClass();
        $this->_data = json_encode($this->_data);

        $response = parent::curl("login", $this->_data);

        return $response;
    }

    public function information() {
        if (!$this->_data) return false;
        if (empty($this->_data) || !(array)$this->_data) $this->_data = new \stdClass();
        $this->_data = json_encode($this->_data);

        $response = parent::curl("profile/session", $this->_data);

        return $response;
    }
}