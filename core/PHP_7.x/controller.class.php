<?php

abstract class Controller {

    protected $param;
    protected $http;
    protected $utils;

    public function __construct(array $param, string $version) {
        
        $this->utils = [];
        
        $this->param = $param;
        $this->http = new HTTPManager();
        require_once __DIR__ . "/../../$version/extended.costructor.php";
    }

}
