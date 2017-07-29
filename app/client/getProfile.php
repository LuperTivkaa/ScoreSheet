<?php
//session_start();
include 'inc/regSession.php';
$clientid = $_SESSION['sess_info'][0];
//function to generate unique number below
//Autoload classes
include'inc/autoload.php';
$client = new client();

$client->schProfile($clientid);
    
