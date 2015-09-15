<?php
// Start Session to save oauth token in session (instead of cookie)
session_start();

// Include PHP SDK Client and a config file with credentials
require_once __DIR__ . '/../vendor/autoload.php';
require_once(__DIR__ . '/config.php');

// Instantiate the SDK client
$client = new VGS_Client($SPID_CREDENTIALS);
$client->argSeparator = '&';

// When a logout redirect comes from SPiD, delete the local session
if (isset($_GET['logout'])) {
  unset($_SESSION['sdk']);
}

// Code is part of the redirect back from SPiD, redirect to self to remove it from URL
// since it may only be used once, and it has been used to create session
if (isset($_GET['code'])) {
  // Get/Check if we have local session, creates ones if code GET param comes
  $_SESSION['sdk'] = $client->getSession();
  header("Location: " . $client->getCurrentURI(array(), array('code', 'login', 'logout')));
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>SPiD Client user login and authentication example</title>
  <meta charset="utf-8">
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
          VGS.Auth.logout(function(){
            document.location.href = document.location + "?logout=1"
          });
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
<h1>SPiD Client user login and authentication example</h1>
<?php

// May get credential errors
if (isset($_GET['error'])) {
  echo '<h3 id="message" style="color:red">' . $_GET['error'] . '</h3>';
}

$session = isset($_SESSION['sdk']) ? $_SESSION['sdk'] : false;
// If we have session, that means we are logged in.
if ($session) {
  // Authorize the client with the session saved user token
  $client->setAccessToken($session['access_token']);

  // Try since SDK may throw VGS_Client_Exceptions:
  //   For instance if the client is blocked, has exceeded ratelimit or lacks access right
  try {

    // Grab the logged in user's User Object, /me will include the entire User object
    $user = $client->api('/me');
    echo '<h3 id="message">Welcome</h3>
            <h4>Logged in as <span id="name" style="color:blue">' . $user['displayName'] . '</span><br/>';
    echo '<small>id: <span id="userId" style="color:green">' . $user['userId'] . '</span><br/>';
    echo 'email: <span id="email" style="color:purple">' . $user['email'] . '</span></h4>';
    if (isset($_GET['order_id'])) {
      echo '<pre>' . print_r($client->api('/order/' . $_GET['order_id']), true) . '</pre>';
    }
  } catch (VGS_Client_Exception $e) {
    if ($e->getCode() == 401) {
      // access denied, in case the access token is expired, try to refresh it
      try {
        // refresh tokens using the session saved refresh token
        $client->refreshAccessToken($session['refresh_token']);
        $_SESSION['sdk']['access_token'] = $client->getAccessToken();
        $_SESSION['sdk']['refresh_token'] = $client->getRefreshToken();
        // Sesssion refreshed with valid tokens
        header("Location: " . $client->getCurrentURI(array(), array('code', 'login', 'error', 'logout', 'order_id', 'spid_page')));
        exit;
      } catch (Exception $e2) {
        /* falls back to $e message bellow */
      }
    }
    if ($e->getCode() == 400) {
      header("Location: " . $client->getLoginURI(array('redirect_uri' => $client->getCurrentURI(array(), array('logout', 'error', 'code', 'order_id', 'spid_page')))));
      exit;
    }
    // API exception, show message, remove session as it is probably not usable
    unset($_SESSION['sdk']);
    echo '<h3 id="error" style="color:red">' . $e->getCode() . ' : ' . $e->getMessage() . '</h3>';
  }
  echo '<p><a id="login-link" href="' . $client->getAccountURI(array('redirect_uri' =>
      $client->getCurrentURI(array(), array('logout', 'error', 'code', 'order_id', 'spid_page'))
    )) . '">My Account</a> | ';
  // Show a logout link
  echo '<a id="login-link" href="' . $client->getLogoutURI(array('redirect_uri' =>
      $client->getCurrentURI(array('logout' => 1), array('error', 'code', 'order_id', 'spid_page'))
    )) . '">Logout</a></p>';

} else { // No session, user must log in

  echo '<h3 id="message">Please log in</h3>';

  // Show a login link
  echo '<p><a id="login-link" href="' . $client->getLoginURI(array(
      'redirect_uri' => $client->getCurrentURI(array(), array('logout', 'error', 'code', 'default', 'cancel', 'order_id', 'spid_page')),
      'cancel_redirect_uri' => $client->getCurrentURI(array('cancel' => 1), array('logout', 'error', 'code', 'default', 'cancel', 'order_id', 'spid_page')),
    )) . '">Login</a> | ';
  echo '<a id="signup-flow-link" href="' . $client->getSignupURI(array(
      'redirect_uri' => $client->getCurrentURI(array(), array('logout', 'error', 'code', 'order_id', 'spid_page')),
      'cancel_redirect_uri' => "http://google.com"
    )) . '">Signup</a></p>';

}
?>
</body>
</html>