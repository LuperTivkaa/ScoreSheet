<?php
//session_start();
include 'inc/regSession.php';
$clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];
//function to generate unique number below
//Autoload classes
include'inc/autoload.php';
$mystudent = new student();
$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$prefix = filter_input(INPUT_POST, "prefix", FILTER_SANITIZE_STRING);
$seperator = filter_input(INPUT_POST, "seperator", FILTER_SANITIZE_STRING);

$mystudent->setSurname($prefix);
$prefix = $mystudent->getSurname();


$mystudent->addPrefixSettings($prefix,$seperator,$clientid,$userid,$dateCreated,$dateCreated);
    
}
else
{
    echo "Please submit a record";
}