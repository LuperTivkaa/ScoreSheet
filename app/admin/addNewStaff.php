<?php
//session_start();
include 'inc/regSession.php';
$clientid = $_SESSION['user_info'][4];
//function to generate unique number below
//Autoload classes
include'inc/autoload.php';
$client = new client();
$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$pass = filter_input(INPUT_POST, "pass", FILTER_SANITIZE_STRING);
$role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_STRING);


$client->setUserName($username);
$user = $client->getUserName();

$client->setPassword($pass);
$pass = $client->getPassword();

$client->setRole($role);
$role = $client->getRole();


$client->newStaff($username,$pass,$role,$clientid,$dateCreated,$dateCreated);
    
}
else
{
    echo "Please submit a record";
}