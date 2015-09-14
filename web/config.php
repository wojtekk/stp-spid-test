<?php

ini_set("display_errors", "1");
error_reporting(E_ALL);

$ourBaseURL = "http://stp-spid-test.i.bt.no";
$spidBaseURL = "https://payment.schibsted.no";
$clientID = "55f6e4c1efd8c056041fbe75";

$spidClientConfig = array(
	\VGS_Client::CLIENT_ID          => $clientID,
	\VGS_Client::CLIENT_SECRET      => $_ENV['VGS_CLIENT_SECRET'],
	\VGS_Client::CLIENT_SIGN_SECRET => $_ENV['VGS_CLIENT_SIGN_SECRET'],
	\VGS_Client::STAGING_DOMAIN     => "stage.payment.schibsted.no",
	\VGS_Client::PRODUCTION_DOMAIN  => "payment.schibsted.no",
	\VGS_Client::HTTPS              => true,
	\VGS_Client::COOKIE             => false,
	\VGS_Client::API_VERSION        => 2,
	\VGS_Client::REDIRECT_URI       => "http://stp-spid-test.i.bt.no/server-test.php",
	\VGS_Client::PRODUCTION         => false,
	\VGS_Client::DOMAIN             => "stp-spid-test.i.bt.no"
);
