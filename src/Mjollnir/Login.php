<?php

namespace Mjollnir;

class Login extends Request{

    public function curl($data) {
        $response = parent::curl($data);

        return $response;
    }
}