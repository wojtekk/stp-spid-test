<?php

ini_set("display_errors", "1");
error_reporting(E_ALL);

$ourBaseURL = "https://stp-spid-test.i.bt.no";
$spidBaseURL = "https://payment.schibsted.no";
$clientID = "55f88006aaa79ce44cd1ab6f";

$spidClientConfig = array(
	\VGS_Client::CLIENT_ID          => $clientID,
	\VGS_Client::CLIENT_SECRET      => 'rNUxIkQzSieNFCyLvBQW',
	\VGS_Client::CLIENT_SIGN_SECRET => 'aqUOUQU0yRbbdsMzudd9',
	\VGS_Client::STAGING_DOMAIN     => "stage.payment.schibsted.no",
	\VGS_Client::PRODUCTION_DOMAIN  => "payment.schibsted.no",
	\VGS_Client::HTTPS              => true,
	\VGS_Client::COOKIE             => false,
	\VGS_Client::API_VERSION        => 2,
	\VGS_Client::REDIRECT_URI       => "https://stp-spid-test.i.bt.no/server-test.php",
	\VGS_Client::PRODUCTION         => false,
	\VGS_Client::DOMAIN             => "stp-spid-test.i.bt.no"
);
