<?php

class Prova extends Controller {

    /**
     * @method POST
     * @uri_path /prova
     */
    public function create($nome, $v2 /** ecc ...* */) {

//        if (!is_integer($nome) || !is_integer($v2)) {
//            throw new Exception('param not valid', CODE::BADREQUEST);
//        }

        $r = $this->utils['db']->prepare(""
                . " INSERT INTO `prova` ( "
                . "     `nome`, "
                . "     `v2` "
                . " ) VALUES ("
                . "     :v1, "
                . "     :v2 "
                . " );");

        $r->bindParam('v1', $nome, PDO::PARAM_INT);
        $r->bindParam('v2', $v2, PDO::PARAM_INT);
        PDO_EXTENTED::execute($r);

        if ($r->rowCount() !== 1) {
            throw new Exception('', CODE::CONFLICT);
        }

        $this->http->code(CODE::CREATED);
        return ['ID' => $this->utils['db']->lastInsertId()];
    }

    /**
     * @method GET
     * @uri_path /prova
     */
    public function read_list() {

        $sql = 'SELECT * FROM `prova` WHERE TRUE';
        $q = $this->utils['db']->prepare($sql);

        PDO_EXTENTED::execute($q);

        $this->http->code(CODE::OK);
        return $q->fetchAll(PDO::FETCH_UNIQUE | PDO::FETCH_ASSOC);
    }

    /**
     * @method GET
     * @uri_path /prova/:ID
     */
    public function read() {
        $q = $this->utils['db']->prepare(''
                . ' SELECT '
                . '     * '
                . ' FROM `prova` '
                . ' WHERE '
                . '     `ID` = :ID ');

        $q->bindParam('ID', $this->param[':ID'], PDO::PARAM_INT);
        PDO_EXTENTED::execute($q);

        if ($q->rowCount() !== 1) {
            throw new Exception('not exist', CODE::NOTFOUND);
        }

        $this->http->code(CODE::OK);
        return $q->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @method PUT
     * @uri_path /prova/:ID
     */
    public function update($v1, $v2, $v3 /** ecc ...* */) {

        if (!is_integer($v1) || !is_integer($v2) || !is_integer($v3)) {
            throw new Exception('param not valid', CODE::BADREQUEST);
        }

        $r = $this->utils['db']->prepare(""
                . " UPDATE `prova` "
                . " SET "
                . "     `param1` = :v1, "
                . "     `param2` = :v2, "
                . "     `param3` = :v3 "
                . " WHERE "
                . "     `ID` = :ID ");

        $r->bindParam('v1', $v1, PDO::PARAM_INT);
        $r->bindParam('v2', $v2, PDO::PARAM_INT);
        $r->bindParam('v3', $v3, PDO::PARAM_INT);
        $r->bindParam('ID', $this->param[':ID'], PDO::PARAM_INT);

        PDO_EXTENTED::execute($r);

        if ($r->rowCount() !== 1) {
            throw new Exception('', CODE::NOTFOUND);
        }

        $this->http->code(CODE::NOCONTENT);
        return;
    }

    /**
     * @method PATCH
     * @uri_path /prova/:ID
     */
    public function update_value($index, $value) {
        if (!in_array($index, ['param1', 'param2', 'param3']) || !is_integer($value)) {
            throw new Exception('param not valid', CODE::BADREQUEST);
        }

        $r = $this->utils['db']->prepare(""
                . " UPDATE `prova` "
                . " SET "
                . "     :index = :value "
                . " WHERE "
                . "     `ID` = :ID ");

        $r->bindParam('index', $index, PDO::PARAM_STR);
        $r->bindParam('value', $value, PDO::PARAM_INT);
        $r->bindParam('ID', $this->param[':ID'], PDO::PARAM_INT);

        PDO_EXTENTED::execute($r);

        if ($r->rowCount() !== 1) {
            throw new Exception('', CODE::NOTFOUND);
        }

        $this->http->code(CODE::NOCONTENT);
        return;
    }

    /**
     * @method DELETE
     * @uri_path /prova/:ID
     */
    public function delete() {
        $q = $this->utils['db']->prepare(""
                . " DELETE FROM `prova` "
                . " WHERE "
                . "     `ID` = :ID");
        $q->bindParam('ID', $this->param[':ID'], PDO::PARAM_INT);

        PDO_EXTENTED::execute($q);

        if ($q->rowCount() !== 1) {
            throw new Exception('not exist', CODE::NOTFOUND);
        }

        $this->http->code(CODE::NOCONTENT);
        return;
    }

    /**
    * @method POST
    * @uri_path /echo1/A
    */
    public function echo1($param) {
      return $param;
    }

}
