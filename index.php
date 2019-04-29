<?php

$php_version = 'PHP_7.x';

require_once __DIR__ . "/core/$php_version/controller.class.php";
require_once __DIR__ . "/core/$php_version/http.class.php";
require_once __DIR__ . "/core/$php_version/routing.class.php";
require_once __DIR__ . "/core/$php_version/superglobal.class.php";
require_once __DIR__ . "/core/$php_version/bootstrap.class.php";

//check all netbeans warning
//CHECK sull'ordine del passaggio dei parametri
//
//la classe bootstrap.class.php può essere suddivisa
//in ogni chiamata nei controlli può essere difinito nei commenti uri e http_method
//se un percorso non esiste fa il check in tutti i controller ed aggiorna la routingtable
//
//dati db in un file a parte
//
//classe non definita - errore
//metodo della classe non definito - errore
//parametri sbagliati 
//v2 not exist
//permessi su cartelle (datidb, rotte, ecc)
//filterinput param

//eccezioni personalizzate: throw new ContactFRMException();
//Struttura progetto
//definizione del tipo di parametri da passare nei metodi delle classi

//sistemare noContent, il "return;" da null

//file di config con: debugMode, php version, basepath, default version
//costruttore di controller estendibile???
//sistemare problema con accesso dall'esterno access-control-origin
//route.controller.json?? per ogni controller un route.json???
//cache control (da specificare nelle rotte)
//favicon solve
//il POST DEVE ESSERE inviato con un json
//
//
//possibilità di rispondere con: csv xml json
//autoload path class in bootstrap (classe db)
//
//
//repo
//composer?
//docker?
//php 7.3?
//IIS?
//nginx?

//test e confronto sulla velocità di risposta


//Utilis folder:
    //DATABASE
    //JWT TOKEN MANAGER
    //CONSTANT PREG_MATCH
    //VALIDATOR
    


/**
 * 
 * CAMBIAMENTI 27/04/2019:
 * 
 * STRUTTURA IN PIù FILE
 * INSERITI CODICI DI ERRORE NEI THROW DEL FRAMEWORK
 * I THROW NEI CONTROLLE ACCETTANO ORA I CODICI DI ERRORE HTTP
 * IMPLEMENTATA CLASSE DI COSTANTI CODICI DI ERRORE
 * POSSIBILITà DI SETTARE IL LO STATUS CODE PRIMA DEL RETURN NEL CONTROLLER
 * RINOMINATE CARTELLE INUTILIZZATE
 * PREPARATO AMBIENTE PER PIù VERSIONI DEL PHP
 * AGGIUNTO FILE extended.costrucotr.php
 * CARTELLA SUBPROJECT 
 * 
 * **/

/**
 * 
 * CAMBIAMENTI 28/04/2019:
 * 
 * AGGIUNTO FILE DI CONFIGURAZIONE, ANCORA NON ATTIVO
 * NEL CONTROLLER "return;" NON STAMPA "null" AL CLIENT MA IL NOCONTENT
 * INSERITA CLASSE GESTIONE DB
 * PDO_EXTENTED CLASS
 * 
 * **/

/**
 * 
 * CAMBIAMENTI 29/04/2019:
 * 
 * INSERITA CHIAMATA DI UPDATE FILE ROUTE
 * DEFINITI NEI CONTROLLER I COMMENTI PER LE ROTTE
 * 
 * **/