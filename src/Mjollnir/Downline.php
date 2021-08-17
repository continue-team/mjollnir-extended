<?php

namespace Mjollnir;

use Mjollnir\Helper;

class Downline extends Request
{

    public $_bearerToken = false;

    public function __construct() {
        parent::__construct();

        if (\getenv("MJOLLNIR_APP_ID") === null || empty(\getenv("MJOLLNIR_APP_ID"))) throw new \Exception('Wrong configuration');
        $this->_bearerToken = \getenv("MJOLLNIR_APP_ID");
    }

    public function create($data=array()) {
        $data = Helper::encrypt($data);
        $data = json_encode($data);

        $response = parent::curl("profile/create", $data, $this->_bearerToken);

        return $response;
    }

    public function information($data=array()) {
        $data = Helper::encrypt($data);
        $data = json_encode($data);

        $response = parent::curl("profile/detail", $data, $this->_bearerToken);

        return $response;
    }

    public function list($data=array()) {
        $data = Helper::encrypt($data);
        $data = json_encode($data);

        $response = parent::curl("profile", $data, $this->_bearerToken);

        return $response;
    }

    public function listByGroup($data=array()) {
        $data = Helper::encrypt($data);
        $data = json_encode($data);

        $response = parent::curl("group/downline", $data, $this->_bearerToken);

        return $response;
    }
}