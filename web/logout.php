<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once(__DIR__ . '/config.php');

session_start();
$client = isset($_SESSION['client']) ? $_SESSION['client'] : false;
if ($client) {
  unset($_SESSION['client']);
  unset($_SESSION['user']);
  $spidLogoutURL = $spidBaseURL . "/logout" .
    "?redirect_uri=" . $ourBaseURL . '/server-test.php' .
    "&oauth_token=" . $client->getAccessToken();
  header("Location: " . $spidLogoutURL);
}
