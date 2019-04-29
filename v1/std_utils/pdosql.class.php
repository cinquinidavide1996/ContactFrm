<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MySQLManager
 *
 * @author HEW15AK110NL
 */
class MySQLManager {

    private $conn;

    public function __construct($host, $user, $pass, $db) {
        $this->conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    public function getConn() {
        return $this->conn;
    }
    
}

class PDO_EXTENTED {
    static function execute($q, array $p = []) {
        try {
            $q->execute();
        } catch (PDOException $e) {
            if (array_key_exists($e->getCode(), $p)) {
                throw new Exception(
                        $p[$e->getCode()]['message'], 
                        $p[$e->getCode()]['code']
                );
            }
            
            throw new Exception('undefined error', CODE::INTERNALSERVERERROR);
        }
    }
}
