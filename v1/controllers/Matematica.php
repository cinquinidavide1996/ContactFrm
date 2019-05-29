<?php

class Matematica extends Controller {

    /**
     * @method GET
     * @uri_path /math/:op/values
     */
    public function execute($v1, $v2) {
        return eval("return " . $this->param[':op'] . ";");
    }
    
    /**
     * @method GET
     * @uri_path /math/:ooo/cia
     */
    public function aa() {
        return $this->param[':ooo'];
    }
    

}
