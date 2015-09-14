<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once(__DIR__ . '/config.php');

$client = new VGS_Client($spidClientConfig);
$session = $client->getSession();
$client->setAccessToken($session['access_token']); 

$user = $client->api('/me');
session_start();
$_SESSION['client'] = $client;
$_SESSION['user'] = $user;

header("Location: /serwer-test.php");
