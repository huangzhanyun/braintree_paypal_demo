<?php
session_start();
include_once '../braintree-php-3.35.0/lib/autoload.php';
$config = include '../config.php';
$gateway = new Braintree_Gateway($config);

//$client_token =  $gateway->ClientToken()->generate();
//echo $client_token;