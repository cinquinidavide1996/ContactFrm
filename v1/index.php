<html>
  <head>
    <script src="http://contactfrm.localhost/v1/js/rpc.js"></script>
    <style>
      pre {
/*
        background: lightcyan;
        padding: 10px;
        */
      }
    </style>
    <title>ContactFrm - PHP Framework</title>
  </head>
  <body>
    <h1>ContactFrm</h1>
    <hr>
    <h2>Il Framework</h2>
    <p>
      ContactFrm è un PHP framework che implementa una logica RESTful e
      tramite il metodo class2JS, una logica RPC opzionale. L'intero progetto è
      repositorato su GitHub:
      <a href="https://github.com/cinquinidavide1996/ContactFrm" target="_blank">https://github.com/cinquinidavide1996/ContactFrm</a>
    </p>
    <h2>Funzionamento componente RESTful</h2>
    <h3>Routing base</h3>
    <p>
      Ogni chiamata viene descritta all'interno della cartella /v1/controllers.
      La cartella contiene una serie di controller. Esempio il file Matematica.php,
      con il codi PHP:
    </p>
<pre>
class Matematica extends Controller {

  /**
  * @method GET
  * @uri_path /math/moltiplicazione
  */
  public function moltiplica($v1, $v2) {
    return $v1 * $v2;
  }

}
</pre>
    <p>
      A una richiesta GET all url "www.dominio.it/v1/math/moltiplicazione?v1=5&v2=12"
      ritornerà quindi il valore 60.
      I parametri $v1 e $v2 verranno passati con il verbo HTTP specificato nel
      commento sopra la chiamata, in questo caso col il verbo GET.
    </p>
  </body>
  <h3>Parametri nelle rotte</h3>
  <p>
    È inoltre possibile passare dei parametri nelle rotte:
  </p>
<pre>
class Matematica extends Controller {

  /**
  * @method POST
  * @uri_path /math/moltiplica/:v1/con/:v2
  */
  public function moltiplica() {
    return $this->param[':v1'] * $this->param[':v2']
  }

}
</pre>
  <p>
    In questo caso una chiamata POST all'url "www.dominio.it/v1/math/moltiplica/6/con/3"
    ritornerà quindi il valore 18.
  </p>
</html>
