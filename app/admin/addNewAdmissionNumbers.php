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
$staff->adminUser($roleid,$clientid);

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
$student->newAdmissionNumber($clientid,$range,$dateCreated);    
    }
    else
    {
    echo "Please submit a record";
    }