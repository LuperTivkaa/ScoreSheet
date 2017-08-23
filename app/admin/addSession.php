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

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$session = filter_input(INPUT_POST, "session", FILTER_SANITIZE_STRING);
//$pass = filter_input(INPUT_POST, "pass", FILTER_SANITIZE_STRING);
//$role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_STRING);

if(empty($session)){
	exit("Please provide a session");
}


$client->newAcademicSession($session,$clientid);
    
}
else
{
    echo "Please submit a record";
}