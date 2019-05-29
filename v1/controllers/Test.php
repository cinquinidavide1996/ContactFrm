<?php

class Test extends Controller {

    /**
     * @method GET
     * @uri_path /math2/:operand/exe
     */
    public function ex22($p1) {
        return $this->param[':operand'] * $p1;
    }

}
