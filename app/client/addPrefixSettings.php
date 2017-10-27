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
$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$prefix = filter_input(INPUT_POST, "prefix", FILTER_SANITIZE_STRING);
//$seperator = filter_input(INPUT_POST, "seperator", FILTER_SANITIZE_STRING);

$student->setSurname($prefix);
$prefix = $student->getSurname();


$student->addPrefixSettings($prefix,$clientid,$userid,$dateCreated,$dateCreated);
    
}
else
{
    echo "Please submit a record";
}