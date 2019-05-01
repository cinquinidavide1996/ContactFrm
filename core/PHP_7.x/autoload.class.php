<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of autoload
 *
 * @author HEW15AK110NL
 */
class AutoloadManager {

    public function __construct() {
        ;
    }

    public function load(string $path) {
        foreach (glob("$path*.php") as $filename) {
            include_once $filename;
        }
    }

}
