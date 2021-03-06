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
$roleid = $_SESSION['user_info'][2];
$staff->clientUser($roleid,$clientid);
//$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$subjectid = filter_input(INPUT_POST, "subjectid",FILTER_SANITIZE_NUMBER_INT);
$categoryid = filter_input(INPUT_POST, "category", FILTER_SANITIZE_NUMBER_INT);
//$role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_STRING);

if(empty($subjectid && $categoryid)){
	exit("Please select appropriate datasets!");
}

$client->assignSubject($subjectid,$categoryid,$clientid);
    
}
else
{
    echo "Please submit a record";
}