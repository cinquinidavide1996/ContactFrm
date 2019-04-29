<?php

class SGlobalManager {

    public function __construct() {
        
    }

    public function getURI(): string {
        return parse_url(filter_input(INPUT_SERVER, 'REQUEST_URI'), PHP_URL_PATH);
    }

    public function getMethod(): string {
        $method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

        if (!in_array($method, [
                    "GET",
                    "HEAD",
                    "POST",
                    "PUT",
                    "DELETE",
                    "CONNECT",
                    "OPTIONS",
                    "TRACE",
                    "PATCH"])) {
            throw new Exception("unexpected http method.", CODE::INTERNALSERVERERROR);
        }

        return $method;
    }

    public function getGET(): array {
        return $_GET;
    }

    public function getPOST(): array {
        return $_POST;
    }

}
