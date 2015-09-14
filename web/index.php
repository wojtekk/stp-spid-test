<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>STP SPiD Test</title>
  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="https://payment.schibsted.no/js/spid-sdk-1.7.9.min.js"></script>
  <script>
  // Add event subscribers
  VGS.Event.subscribe('auth.login', function(data) { console.log(data); });
  VGS.Event.subscribe('auth.logout', function(data) { console.log(data); });
  VGS.Event.subscribe('auth.sessionChange', function(data) { console.log(data); });
  
  //Initiate SDK
  VGS.init({
    client_id: "55f6e4c1efd8c056041fbe75",
    server: "payment.schibsted.no"
  });
  </script>
</head>
<body>
  <h1>STP SPiD Test</h1>
  <dl>
    <dt>Options</dt>
    <dd><a href="">Login</a></dd>
    <dd><a href="">Logout</a></dd>
    <dt>User</dt>
    <dd></dd>
  </dl>
</body>
</html>