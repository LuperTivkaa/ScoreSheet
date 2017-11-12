<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
use Carbon\Carbon;
//use \PDO;
$dbConnection = new dbConnection();
$client = new client($dbConnection);
$student = new student($dbConnection);
$staff = new staff($dbConnection);

$clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];
$staff->adminUser($userid,$clientid);
//$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
  $date = filter_input(INPUT_POST, "date", FILTER_SANITIZE_STRING);
  //$term = filter_input(INPUT_POST, "term", FILTER_SANITIZE_NUMBER_INT);
  //$session = filter_input(INPUT_POST, "session", FILTER_SANITIZE_NUMBER_INT);

if(empty($date)){
	exit("Please fill all fields...");
}


$client->resumptionDate($clientid,$date);
    
}
else
{
    echo "Please submit a record";
}