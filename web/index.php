<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>STP SPiD Test</title>
  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="https://payment.schibsted.no/js/spid-sdk-1.7.9.min.js"></script>
  <style>
    dd {
      display: none;
    }

    #user {
      display: block;
    }
  </style>
  <script>
    $(document).ready(function () {
      function handleUser(response) {
        if (typeof (response.session) === 'object' && response.status === 'connected') {
          handleLoginUsers(response)
        } else {
          handleLogoutUsers(response);
        }
      }

      function handleLoginUsers(response) {
        $("#logout").show();

        $("#logout a").attr("href", VGS.getLogoutURI());
        $("#logout a").click(function () {
          VGS.Auth.logout();
        });
        $("#user").html('<a href="' + VGS.getAccountURI() + '">' + response.session.displayName + '</a>');
      }

      function handleLogoutUsers(response) {
        $("#login").show();
        $("#signup").show();
        $("#user").text("Not logged in");

        $("#login a").attr("href", VGS.getLoginURI());
        $("#signup a").attr("href", VGS.getSignupURI());
      }

      VGS.Event.subscribe('auth.sessionChange', function (response) {
        console.log("auth.sessionChange", response);
        handleUser(response);
      });

      VGS.Event.subscribe('VGS.error', function (response) {
        console.log("VGS.error", response);
        handleUser(response);
      });

      VGS.init({
        client_id: "55f6e4c1efd8c056041fbe75",
        server: "payment.schibsted.no"
      });
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
