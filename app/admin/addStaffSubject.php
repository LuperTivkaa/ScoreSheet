<?php
//session_start();
include 'inc/regSession.php';
$clientid = $_SESSION['user_info'][4];
//$userid = $_SESSION['user_info'][0];
//function to generate unique number below
//Autoload classes
include'inc/autoload.php';
$client = new client();
$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$staff = filter_input(INPUT_POST, "staff", FILTER_SANITIZE_NUMBER_INT);
$myclass = filter_input(INPUT_POST, "subj_class", FILTER_SANITIZE_NUMBER_INT);
$subject = filter_input(INPUT_POST, "subj", FILTER_SANITIZE_NUMBER_INT);


$client->addSubject($subject,$myclass,$staff,$clientid,$dateCreated,$dateCreated);
    
}
else
{
    echo "Please submit a record";
}