<?php
//session_start();
include 'inc/regSession.php';
$clientid = $_SESSION['sess_info'][0];
//function to generate unique number below
//Autoload classes
include'inc/autoload.php';
$client = new client();
$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$staff = filter_input(INPUT_POST, "staff", FILTER_SANITIZE_STRING);
$myclass = filter_input(INPUT_POST, "subj_class", FILTER_SANITIZE_STRING);
$subject = filter_input(INPUT_POST, "subj", FILTER_SANITIZE_STRING);


// $client->setUserName($username);
// $user = $client->getUserName();

// $client->setPassword($pass);
// $pass = $client->Password();

// $client->setRole($role);
// $role = $client->getRole();


$client->addSubject($subject,$myclass,$staff,$clientid,$dateCreated,$dateCreated,$clientid);
    
}
else
{
    echo "Please submit a record";
}