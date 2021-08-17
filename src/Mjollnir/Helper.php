<?php

namespace Mjollnir;

class Helper
{

    /**
    * get access token from header
    * */
    static function getBearerToken() {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }

        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    static function isJson($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    static function encrypt($data) {
        if (\getenv("MJOLLNIR_APP_SECRET") === null || empty(\getenv("MJOLLNIR_APP_SECRET"))) throw new \Exception('Wrong configuration');

        unset($data["hash"]);
        unset($data["force"]);
        ksort($data);
        $stringToEncrypt = "";
        foreach ($data as $key=>$dat) {
            $stringToEncrypt .= $dat.".";
        }
        $stringToEncrypt = substr($stringToEncrypt, 0, -1);

        $data["hash"] = hash_hmac('sha256', $stringToEncrypt, \getenv("MJOLLNIR_APP_SECRET"));
        
        return $data;
    }
}