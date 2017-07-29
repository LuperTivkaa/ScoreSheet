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
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$pass = filter_input(INPUT_POST, "pass", FILTER_SANITIZE_STRING);
$role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_STRING);


$client->setEmail($email);
$email = $client->getEmail();

$client->setUserName($username);
$user = $client->getUserName();

$client->setPassword($pass);
$pass = $client->getPassword();

$client->setRole($role);
$role = $client->getRole();


$client->newStaff($email,$username,$pass,$role,$clientid,$dateCreated,$dateCreated);
    
}
else
{
    echo "Please submit a record";
}