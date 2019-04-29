<?php

class HTTPManager {

    public function __construct() {
        
    }

    public function setHeader() {
        header("Content-Type: application/json; charset=UTF-8");
        header('Access-Control-Allow-Origin: *');
    }

    public function code(int $code) {
        switch ($code) {
            case 200:
            case 201:
            case 204:
            case 302:
            case 400:
            case 401:
            case 403:
            case 404:
            case 405:
            case 409:
            case 418:
            case 429:
            case 500:
            case 501:
                http_response_code($code);
                break;
            default:
                throw new Exception('http status code not allowed', CODE::INTERNALSERVERERROR);
        }
    }

}

class CODE {

    const OK = 200;
    const CREATED = 201;
    const NOCONTENT = 204;
    const FOUND = 302;
    const BADREQUEST = 400;
    const UNATHORIZED = 401;
    const FORBIDDEN = 403;
    const NOTFOUND = 404;
    const METHODNOTALLOWED = 405;
    const CONFLICT = 409;
    const IMATEAPOT = 418;
    const TOOMANYREQUEST = 429;
    const INTERNALSERVERERROR = 500;
    const NOTIMPLEMENTED = 501;

}
