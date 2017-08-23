<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use Carbon\Carbon;
//use \PDO;
$dbConnection = new dbConnection();
$client = new client($dbConnection);
$student = new student($dbConnection);

$clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];
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