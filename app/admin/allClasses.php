<?php
include 'inc/regSession.php';
$clientid = $_SESSION['user_info'][4];
//including classes
include 'inc/autoload.php';

$myClient = new client();


$myClient->loadClass($clientid);

?>
