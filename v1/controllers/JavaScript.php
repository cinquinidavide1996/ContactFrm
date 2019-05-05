<?php

class JavaScript {
/**
 * @method GET
 * @uri_path /js/rpc.js
 */
public function route() {
  foreach (glob(__DIR__ . "/*.php") as $k => $v) {
      include_once $v;
      $explosesFilename = explode('/', $v);
      $current_class = substr(end($explosesFilename), 0, -4);
      $result[$current_class] = [
      ];
  }
  $getURIParam = function($path) {
    $r = [];
    $exp = explode('/', $path);
    foreach($exp as $k => $v) {
        if (substr($v, 0, 1) == ':') {
            $r[] = str_replace(':', '', $v);
        }
    }
    return $r;
  };
  foreach ($result as $k => &$v) {
      $v['constructor'] = [];
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

          $fparam = [];
          foreach($ref->getParameters() as $k4 => $v4) {
            $fparam[] = $v4->getName();
          }

          if ($v2 !== '__construct') {
            $v[$v2] = [
              'verb' => $r['method'],
              'uri' => $r['uri_path'],
              'param' => $fparam
            ];

            foreach($getURIParam($r['uri_path']) as $k7 => $v7) {
                if (!in_array($v7, $v['constructor'])) {
                  $v['constructor'][] = $v7;
                }
            }
          }
      }
  }
foreach($result as $k => &$v) {
  foreach($v as $k2 => &$v2) {
    if ($k2 !== 'constructor') {
      foreach($v['constructor'] as $k3 => $v3) {
        $v2 = str_replace(":$v3", "\" + this.$v3 + \"", $v2);
      }
    }
  }
}
    //return $result;
    header("Content-Type: application/javascript; charset=UTF-8");
    $ajaxTemplate = [];

    $ajaxTemplate['POST'] = 'var xhttp=new XMLHttpRequest;var data= new FormData();{{param}}xhttp.onreadystatechange=function(){4==this.readyState&&200==this.status&&console.log(this.responseText)},xhttp.open("{{method}}","{{path}}",!0),xhttp.send(data);';
    $ajaxTemplate['GET'] = 'var xhttp=new XMLHttpRequest;xhttp.onreadystatechange=function(){4==this.readyState&&200==this.status&&console.log(this.responseText)},xhttp.open("{{method}}","{{path}}?{{param}}",!0),xhttp.send();';

    foreach($result as $k1 => $v1) {
      echo "class $k1{";
      foreach($v1 as $k2 => $v2) {
        if ($k2 === 'constructor') {
            echo "constructor(";
            $lastElement = end($v2);
            foreach($v2 as $ck1 => $cv1) {
              echo "$cv1";
              if ($cv1 !== $lastElement) {
                echo ',';
              }
            }
            echo "){" ;
              foreach($v2 as $ck1 => $cv1) {
                echo "this.$cv1 = $cv1;";
              }
              echo "}";
        } else {
        echo "$k2(";
        $lastElement = end($v2['param']);
        $sendParam = "";
        foreach($v2['param'] as $k3 => $v3) {
          echo "$v3";
          if ($v3 !== $lastElement) {
            echo ',';
          }
          if ($v2['verb'] === 'GET') {
            $sendParam .= "&$v3=\" + $v3 + \"";
          } else {
              $sendParam .= "data.append('$v3', $v3);";
          }
        }

        $methodf = str_replace('{{method}}', $v2['verb'], $v2['verb'] === 'GET'?$ajaxTemplate['GET']:$ajaxTemplate['POST']);
        $methodf = str_replace('{{path}}', "/v1$v2[uri]", $methodf);
        $methodf = str_replace('{{param}}', $sendParam, $methodf);
        echo"){" . $methodf . "}";
      }

      }

      foreach($v1['constructor'] as $k9 => $v9) {
        echo "_set$v9($v9){this.$v9 = $v9;}";
      }

      echo "}";
    }
exit();
    return;
}

/**
 * @method GET
 * @uri_path /js/class2json
 */
public function class2Json() {
  foreach (glob(__DIR__ . "/*.php") as $k => $v) {
      include_once $v;
      $explosesFilename = explode('/', $v);
      $current_class = substr(end($explosesFilename), 0, -4);
      $result[$current_class] = [
      ];
  }
  $getURIParam = function($path) {
    $r = [];
    $exp = explode('/', $path);
    foreach($exp as $k => $v) {
        if (substr($v, 0, 1) == ':') {
            $r[] = str_replace(':', '', $v);
        }
    }
    return $r;
  };
  foreach ($result as $k => &$v) {
      $v['constructor'] = [];
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

          $fparam = [];
          foreach($ref->getParameters() as $k4 => $v4) {
            $fparam[] = $v4->getName();
          }

          if ($v2 !== '__construct') {
            $v[$v2] = [
              'verb' => $r['method'],
              'uri' => $r['uri_path'],
              'param' => $fparam
            ];

            foreach($getURIParam($r['uri_path']) as $k7 => $v7) {
                if (!in_array($v7, $v['constructor'])) {
                  $v['constructor'][] = $v7;
                }
            }
          }
      }
  }

  return $result;
}

}
