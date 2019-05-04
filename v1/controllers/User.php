<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author HEW15AK110NL
 */
class User extends Controller {

    /**
     * @method GET
     * @uri_path /aaa
     */
    public function getList($textFilter) {
        $sql = 'SELECT ID, name, email FROM user WHERE TRUE';
        $sql .= $textFilter !== '' ? ' AND (name LIKE :textFilter)' : '';

        $q = $this->utils['db']->prepare($sql);

        if ($textFilter !== '') {
            $textFilter = "%$textFilter%";
            $q->bindParam('textFilter', $textFilter, PDO::PARAM_STR);
        }

        PDO_EXTENTED::execute($q);

        $this->http->code(CODE::OK);
        return $q->fetchAll(PDO::FETCH_UNIQUE | PDO::FETCH_ASSOC);
    }

    /**
     * @method GET
     * @uri_path /user/:UserID
     */
    public function detail() {
        $q = $this->utils['db']->prepare(''
                . ' SELECT '
                . '     ID, '
                . '     email, '
                . '     name, '
                . '     username '
                . ' FROM user '
                . ' WHERE '
                . '     ID = :UserID ');

        $q->bindParam('UserID', $this->param[':UserID'], PDO::PARAM_INT);
        PDO_EXTENTED::execute($q);

        if ($q->rowCount() !== 1) {
            throw new Exception('user not exist', CODE::NOTFOUND);
        }

        $this->http->code(CODE::OK);
        return $q->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @method POST
     * @uri_path /user
     */
    public function create($username, $password, $name, $email) {
        $q = $this->utils['db']->prepare(""
                . " INSERT INTO user ("
                . "     `username`, "
                . "     `password`, "
                . "     `email`, "
                . "     `name`"
                . " ) VALUES ("
                . "     :username, "
                . "     MD5(:password), "
                . "     :email, "
                . "     :name "
                . " ) ");

        $q->bindParam('username', $username, PDO::PARAM_STR);
        $q->bindParam('password', $password, PDO::PARAM_STR);
        $q->bindParam('email', $email, PDO::PARAM_STR);
        $q->bindParam('name', $name, PDO::PARAM_STR);

        PDO_EXTENTED::execute($q, [
            '23000' => [
                'message' => 'duplicate name or user',
                'code' => CODE::CONFLICT
            ]
        ]);

        $this->http->code(CODE::CREATED);
        return;
    }

    /**
     * @method DELETE
     * @uri_path /user/:UserID
     */
    public function delete() {
        $q = $this->utils['db']->prepare("DELETE FROM user WHERE ID = :UserID");
        $q->bindParam('UserID', $this->param[':UserID'], PDO::PARAM_INT);

        PDO_EXTENTED::execute($q);

        if ($q->rowCount() !== 1) {
            throw new Exception('user not exist', CODE::NOTFOUND);
        }

        $this->http->code(CODE::NOCONTENT);
        return;
    }

    /**
     * @method PUT
     * @uri_path /user/:UserID
     */
    public function update($name, $password) {
        throw new Exception('', CODE::NOTIMPLEMENTED);
    }
    
}
