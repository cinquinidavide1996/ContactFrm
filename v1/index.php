<html>
  <head>
    <script src="http://contactfrm.localhost/v1/js/rpc.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script>
      var doc = new JavaScript
      doc.class2Json().then(function(data) {
        var template = $('#documentation template').html();
        $.each(JSON.parse(data), function(className) {
          $.each(this, function(functionName) {
            if (functionName !== 'constructor') {
              t = template;

              t = t.replace('{{resource}}', className);
              t = t.replace('{{method}}', this.verb);
              t = t.replace('{{name}}', functionName);
              t = t.replace('{{route}}', this.uri);
              t = t.replace('{{route}}', this.uri);
              t = t.replace('{{param}}', this.param.join(','));

              $('#documentation tbody').append(t);
            }
          });
        });
      });
    </script>
    <title>ContactFrm - PHP Framework</title>
  </head>
  <body>
    <div id="documentation">
      <table class="table table-striped table-dark" style="margin: 0px;padding:0px;">
        <thead>
          <tr>
            <th>Resource</th>
            <th>HTTP Method</th>
            <th>Name</th>
            <th>Route</th>
            <th>Param</th>
          </tr>
        </thead>
        <tbody>
        </body>
      </table>
      <template>
        <tr>
          <td>{{resource}}</td>
          <td>{{method}}</td>
          <td>{{name}}</td>
          <td><a href="/v1{{route}}" target="_blank">{{route}}</a></td>
          <td>{{param}}</td>
        </tr>
      </template>
    </div>
  </body>
</html>
