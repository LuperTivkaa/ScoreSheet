<?php
//session_start();
include 'inc/regSession.php';
$clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];
//function to generate unique number below
//Autoload classes
include'inc/autoload.php';
$client = new client();
//REMOVE THE CLIENT ID AND REPLACE WITH USER ID VARIABLE
$client->loadMyTickets($userid);
    
