<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
//use \PDO;
$dbConnection = new dbConnection();
$client = new client($dbConnection);
$clientid = $_SESSION['user_info'][4];

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