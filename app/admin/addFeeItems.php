<?php
//session_start();
include 'inc/regSession.php';
$clientid = $_SESSION['user_info'][4];
//function to generate unique number below
//Autoload classes
include'inc/autoload.php';
$client = new client();
//$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$item = filter_input(INPUT_POST, "item", FILTER_SANITIZE_STRING);
$amount = filter_input(INPUT_POST, "amount", FILTER_SANITIZE_STRING);
$amtwrds = filter_input(INPUT_POST, "amtwrds", FILTER_SANITIZE_STRING);
$term = filter_input(INPUT_POST, "term", FILTER_SANITIZE_STRING);
$session = filter_input(INPUT_POST, "session", FILTER_SANITIZE_STRING);

if(empty($session) || empty($item) || empty($amount) || empty($amtwrds) || empty($term))
{
	exit("Please fill all the fields");
}


$client->feeItem($item,$amount,$amtwrds,$clientid,$term,$session);
    
}
else
{
    echo "Please submit a record";
}