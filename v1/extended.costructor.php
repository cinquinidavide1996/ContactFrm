<?php

$db = new MySQLManager('localhost', 'root', '', 'apidb');
$this->utils['db'] = $db->getConn();