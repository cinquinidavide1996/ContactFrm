<?php

$php_version = 'PHP_7.x';

require_once __DIR__ . "/core/$php_version/autoload.class.php";
$loadCtrl = new AutoloadManager();
$loadCtrl->load(__DIR__ . "/core/$php_version/");

new Bootstrap();