<?php

namespace Mjollnir;

use Mjollnir\Helper;

class Request
{

    public $_url = false;
    public $_data = false;

    public function __construct() {
        if (\getenv("MJOLLNIR_URL") === null || empty(\getenv("MJOLLNIR_URL"))) throw new \Exception('Wrong configuration');
        $this->_url = \getenv("MJOLLNIR_URL");

        $jsonBody = file_get_contents('php://input');
        if (!empty($jsonBody) && $jsonBody !== "") {
            if (!Helper::isJson($jsonBody)) return false;
            $this->_data = json_decode($jsonBody);
        }
    }

    public function validate() {
        if (!$this->_data) return true;
        if (empty($this->_data) || !(array)$this->_data) return true;
        $this->_data = json_encode($this->_data);

        $bearerToken = Helper::getBearerToken();

        $authorization = "Authorization: Bearer ".$bearerToken;
        // Setup cURL
        $ch = curl_init($this->_url."validate");
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HEADER => TRUE,
            CURLOPT_HTTPHEADER => array('Content-Type: Type:application/json', $authorization),
            CURLOPT_POSTFIELDS => $this->_data,
        ));

        // Send the request
        $response = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $response = \json_decode(\substr($response, $header_size));

        if ($response->code !== 200 || $response->data->status !== true) return false;

        return true;
    }

    public function curl($endpoint, $data, $bearerToken=false) {
        if (!$bearerToken) $bearerToken = Helper::getBearerToken();

        $authorization = "Authorization: Bearer ".$bearerToken;
        // Setup cURL
        $ch = curl_init($this->_url.$endpoint);
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HEADER => TRUE,
            CURLOPT_HTTPHEADER => array('Content-Type: Type:application/json', $authorization),
            CURLOPT_POSTFIELDS => $data,
        ));

        // Send the request
        $response = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $response = \json_decode(\substr($response, $header_size));

        return $response;
    }
}