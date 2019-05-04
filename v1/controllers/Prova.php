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
     * @method GET
     * @uri_path /js/route.js
     */
    public function route() {
        $result = [];
        foreach (glob(__DIR__ . "/*.php") as $k => $v) {
            include_once $v;
            $explosesFilename = explode('/', $v);
            $current_class = substr(end($explosesFilename), 0, -4);
            $result[$current_class] = [
            ];
        }

        foreach ($result as $k => &$v) {
            foreach (get_class_methods($k) as $k2 => $v2) {

                $ref = new ReflectionMethod($k, $v2);
                $comment = $ref->getDocComment();

                $comment = str_replace('/*', '', $comment);
                $comment = str_replace('*/', '', $comment);
                $comment = str_replace('*', '', $comment);
                $comment = trim($comment);

                $prm = explode('@', $comment);
                array_shift($prm);
                $r = [];
                foreach ($prm as &$v3) {
                    $v3 = trim($v3);
                    $app = explode(' ', $v3);
                    $r[$app[0]] = $app[1];
                }

                if (isset($r['uri_path']) && isset($r['method'])) {
                $v[$v2] = [
                    'verb' => $r['method'],
                    'uri' => $r['uri_path'],
                    'param' => ''
                ];
                }
            }
        }

        return $result;
    }

}
