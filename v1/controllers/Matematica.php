<?php
class Matematica extends Controller {

  /**
  * @method GET
  * @uri_path /math/:op/values
  */
  public function execute($v1, $v2) {
    switch($this->param[':op']) {
      case 'somma':
        return $v1 + $v2;
        break;
      case 'sottrazione':
        return $v1 - $v2;
        break;
      case 'divisione':
        return $v1 / $v2;
        break;
      case 'moltiplicazione':
        return $v1 * $v2;
        break;
      default:
        throw new Exception('bad request', CODE::BADREQUEST);
    }
  }


}
