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
$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$skill_item = filter_input(INPUT_POST, "skillitem", FILTER_SANITIZE_STRING);
//$seperator = filter_input(INPUT_POST, "seperator", FILTER_SANITIZE_STRING);

//$student->setSurname($prefix);
//$prefix = $student->getSurname();

$client->createPsychoDomain($skill_item,$clientid,$userid,$dateCreated);
    
}
else
{
    echo "Please submit a record";
}