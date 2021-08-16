<?php

namespace Mjollnir;

class Register extends Request{

    public function curl($data) {
        $response = parent::curl($data);

        return $response;
    }
}