<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once(__DIR__ . '/config.php');

session_start();

$spidAuthorizeURL = $spidBaseURL . "/oauth/authorize" .
  "?client_id=" . $clientID .
  "&response_type=code" .
  "&redirect_uri=" . $ourBaseURL . "/createSession.php";

$user = isset($_SESSION['user']) ? $_SESSION['user'] : false;
if ($user) {
  echo "Hello " . $user['displayName'] . "! <a href='/logout.php'>Log out</a>";
} else {
  echo "<a href='" . $spidAuthorizeURL . "'>Log in with SPiD</a>";
}