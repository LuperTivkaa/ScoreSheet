<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
//use \PDO;
$dbConnection = new dbConnection();
$student = new student($dbConnection);
$client = new client($dbConnection);
$staff = new staff($dbConnection);
//$jobmanager = new manager($dbConnection);
$clientid = $_SESSION['user_info'][4];
//$newStaff = new student();
$userid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->clientUser($myroleid,$clientid);

$mystudent = new student($dbConnection);
$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$range = filter_input(INPUT_POST, "range", FILTER_SANITIZE_STRING);

if(empty($range) || !is_numeric($range))
    {
	exit("Please provide how many numbers you wish to generate or provide a valid data");
    }
//creating new admission numbers
$mystudent->newAdmissionNumber($clientid,$range,$dateCreated);    
    }
    else
    {
    echo "Please submit a record";
    }