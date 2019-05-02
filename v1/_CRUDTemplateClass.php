<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of _CRUDTemplateClass
 *
 * @author HEW15AK110NL
 */
class _CRUDTemplateClass extends Controller {

    /**
     * 
     * @method POST
     * @uri_param /crud_template
     */
    public function create($v1, $v2, $v3 /** ecc ...* */) {

        if (!is_integer($v1) || !is_integer($v2) || !is_integer($v3)) {
            throw new Exception('param not valid', CODE::BADREQUEST);
        }

        $r = $this->utils['db']->prepare(""
                . " INSERT INTO `crud_template` ( "
                . "     `v1`, "
                . "     `v2`, "
                . "     `v3`"
                . " ) VALUES ("
                . "     :v1, "
                . "     :v2, "
                . "     :v3 "
                . " );");

        $r->bindParam('v1', $v1, PDO::PARAM_INT);
        $r->bindParam('v2', $v2, PDO::PARAM_INT);
        $r->bindParam('v3', $v3, PDO::PARAM_INT);

        PDO_EXTENTED::execute($r);

        if ($r->rowCount() !== 1) {
            throw new Exception('', CODE::CONFLICT);
        }

        $this->http->code(CODE::CREATED);
        return ['ID' => $this->utils['db']->lastInsertId];
    }

    /**
     * 
     * @method GET
     * @uri_param /crud_template
     */
    public function read_list($filter1, $filter2 /** ecc ...* */) {

        $sql = 'SELECT * FROM `crud_template` WHERE TRUE';
        $sql .= $filter1 !== '' ? ' AND (param1 LIKE :filter1)' : '';
        $sql .= $filter2 !== '' ? ' AND (param2 LIKE :filter2)' : '';

        $q = $this->utils['db']->prepare($sql);

        if ($filter1 !== '') {
            $filter1 = "%$filter1%";
            $q->bindParam('filter1', $filter1, PDO::PARAM_STR);
        }
        if ($filter2 !== '') {
            $filter2 = "%$filter2%";
            $q->bindParam('filter2', $filter2, PDO::PARAM_STR);
        }

        PDO_EXTENTED::execute($q);

        $this->http->code(CODE::OK);
        return $q->fetchAll(PDO::FETCH_UNIQUE | PDO::FETCH_ASSOC);
    }

    /**
     * 
     * @method GET
     * @uri_param /crud_template/:ID
     */
    public function read() {
        $q = $this->utils['db']->prepare(''
                . ' SELECT '
                . '     * '
                . ' FROM `crud_template` '
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
     * 
     * @method PUT
     * @uri_param /crud_template/:ID
     */
    public function update($v1, $v2, $v3 /** ecc ...* */) {

        if (!is_integer($v1) || !is_integer($v2) || !is_integer($v3)) {
            throw new Exception('param not valid', CODE::BADREQUEST);
        }

        $r = $this->utils['db']->prepare(""
                . " UPDATE `crud_template` "
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
     * 
     * @method PATCH
     * @uri_param /crud_template/:ID
     */
    public function update_value($index, $value) {
        if (!in_array($index, ['param1', 'param2', 'param3']) || !is_integer($value)) {
            throw new Exception('param not valid', CODE::BADREQUEST);
        }

        $r = $this->utils['db']->prepare(""
                . " UPDATE `crud_template` "
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
     * 
     * @method DELETE
     * @uri_param /crud_template/:ID
     */
    public function delete() {
        $q = $this->utils['db']->prepare(""
                . " DELETE FROM `crud_template` "
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

}
