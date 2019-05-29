<?php

class Image extends Controller {

    /**
     * @method GET
     * @uri_path /img/:category/:year
     */
    public function imgList() {
        $sql = ""
                . " SELECT link "
                . " FROM prodotto "
                . " WHERE "
                . "     anno = :year AND "
                . "     categoria = :category";
        
        $q = $this->utils['db']->prepare($sql);
        
        $q->bindParam('year', $this->param[':year'], PDO::PARAM_INT);
        $q->bindParam('category', $this->param[':category'], PDO::PARAM_STR);

        PDO_EXTENTED::execute($q);

        $this->http->code(CODE::OK);
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * @method GET
     * @uri_path /math/:ooo/cia
     */
    public function aa() {
        return $this->param[':ooo'];
    }
    

}
