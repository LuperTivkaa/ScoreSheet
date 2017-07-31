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
$subject = filter_input(INPUT_POST, "subjectName", FILTER_SANITIZE_STRING);
$class = filter_input(INPUT_POST, "classid", FILTER_SANITIZE_STRING);
//$role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_STRING);

if(empty($subject && $class)){
	exit("Please select appropriate datasets!");
}

$client->assignSubject($subject,$class,$clientid);
    
}
else
{
    echo "Please submit a record";
}