<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>STP SPiD Test</title>
  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="https://payment.schibsted.no/js/spid-sdk-1.7.9.min.js"></script>
  <script>

  VGS.Event.subscribe('auth.login', function(data) {
      $("#logout").show();
      $("#login").hide();
      $("#logout a").attr("href", VGS.getLogoutURI() )
      $("#user a").text(data.session.displayName);
    });
  
  VGS.Event.subscribe('auth.logout', function(data) {
      $("#logout").hide();
      $("#login").show();
      $("#login a").attr("href", VGS.getLoginURI() )
      $("#user a").text("Not logged in");
    });
    
  VGS.Event.subscribe('auth.sessionChange', function(data) {
    console.log(data);
    });
  
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
    <dd id="login"><a href="">Login</a></dd>
    <dd id="logout"><a href="">Logout</a></dd>
    <dt>User</dt>
    <dd id="user"></dd>
  </dl>
</body>
</html>