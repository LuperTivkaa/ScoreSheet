<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
//use \PDO;

$dbConnection = new dbConnection();
$client = new client($dbConnection);
$clientid = $_SESSION['user_info'][4];

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