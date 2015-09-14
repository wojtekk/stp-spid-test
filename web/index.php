<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>STP SPiD Test</title>
  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="https://payment.schibsted.no/js/spid-sdk-1.7.9.min.js"></script>
  <script>

  function handleLoginUsers(data) {
    $("#logout").show();
    $("#login").hide();
    $("#signup").hide();
    $("#logout a").attr("href", VGS.getLogoutURI() )
    $("#user a").text(data.session.displayName);
  }
  
  function handleLogoutUsers(data) {
    $("#logout").hide();
    $("#login").show();
    $("#signup").show();
    $("#login a").attr("href", VGS.getLoginURI() )
    $("#signup a").attr("href", VGS.getSignupURI() )
    $("#user a").text("Not logged in");
  }

  VGS.Event.subscribe('auth.login', function(data) {
      console.log(data);
      handleLoginUsers(data)
    });
  
  VGS.Event.subscribe('auth.logout', function(data) {
      console.log(data);
      handleLogoutUsers(data);
    });
    
  VGS.Event.subscribe('auth.sessionChange', function(data) {
      console.log(data);
      var sess = data.session || {};
      if( sess ) {
        handleLoginUsers(data)
      } else {
        handleLogoutUsers(data);
      }
    });
  
  VGS.init({
    client_id: "55f6e4c1efd8c056041fbe75",
    server: "payment.schibsted.no"
  });
  </script>
</head>
<body>
  <h1>STP SPiD Test</h1>
  <h2>JavaScript</h2>
  <dl>
    <dt>Options</dt>
    <dd id="signup"><a href="">Signup</a></dd>
    <dd id="login"><a href="">Login</a></dd>
    <dd id="logout"><a href="">Logout</a></dd>
    <dt>User</dt>
    <dd id="user">Unknown</dd>
  </dl>
</body>
</html>
