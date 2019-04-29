<?php

new class {

    private $RoutingCtrl;
    private $HttpCtrl;
    private $SGlobalCtrl;
    private $routeDetail;
    private $className;
    private $object;
    private $param;
    private $methodParam;

    public function __construct() {
        try {
            
            $this->instantiate();
            
            
            require_once __DIR__ 
                    . '/../../' 
                    . $this->RoutingCtrl->getVersion() 
                    . '/std_utils/pdosql.class.php';
            
            $this->HttpCtrl->setHeader();

            $this->routeDetail = $this->RoutingCtrl->getRouteDetail();
            $this->objectIstance();
            $this->setParams();
            
            $this->setMethodParam();
            $this->paramCountCheck();
            
            $result = eval(
                'return $this->object->' 
                . $this->routeDetail['route']['method']
                . '(' . $this->getParamString() . ');'
            );
            
            if ($result !== null) {
                echo json_encode($result);
            }
                                        
        } catch (Exception $e) {
            http_response_code($e->getCode());
            echo json_encode($e->getMessage());
        }
    }

    private function instantiate() {
        $this->HttpCtrl = new HTTPManager();
        $this->SGlobalCtrl = new SGlobalManager();

        $this->RoutingCtrl = new RoutingManager(
                $this->SGlobalCtrl->getURI(), $this->SGlobalCtrl->getMethod()
        );
    }

    private function getClassPath(): string {
        $classPath = __DIR__ . '/../../';
        $classPath .= $this->RoutingCtrl->getVersion();
        $classPath .= $this->routeDetail['route']['class'];

        return $classPath;
    }

    private function getClassName(): string {
        $expClassPath = explode('/', $this->routeDetail['route']['class']);
        return substr(end($expClassPath), 0, -4);
    }

    private function objectIstance() {
        require_once $this->getClassPath();
        $this->className = $this->getClassName();
        $this->object = new $this->className(
                $this->routeDetail['param'], 
                $this->RoutingCtrl->getVersion()
        );
    }

    private function setParams() {
        if ($this->SGlobalCtrl->getMethod() === 'GET') {
            $this->param = $this->SGlobalCtrl->getGET();
        } else {
            $this->param = $this->SGlobalCtrl->getPOST();
        }
    }
    
    private function setMethodParam() {
        $ReflectionMethod =  new \ReflectionMethod(
                $this->className, $this->routeDetail['route']['method']
        );

        $this->methodParam = array_map(function($item) {
            return $item->getName();
        }, $ReflectionMethod->getParameters());
    }
    
    private function paramCountCheck() {
        if (count($this->methodParam) !== count($this->param)) {
            throw new Exception('param not match', CODE::INTERNALSERVERERROR);
        }
        
        foreach($this->param as $k => $v) {
            if (!in_array($k, $this->methodParam)) {
                throw new Exception('param not match', CODE::INTERNALSERVERERROR);
            }
        }
    }
    
    private function getParamString(): string {
        if (count($this->methodParam) === 0) {
            return '';
        }
        
        $result = '';
        foreach($this->methodParam as $v) {
            $result .= "'" . $this->param[$v] . "',";
        }
        return substr($result, 0, -1);
    }
};
