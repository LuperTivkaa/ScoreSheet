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
$category = filter_input(INPUT_POST, "category", FILTER_SANITIZE_STRING);
 // $category = filter_input(INPUT_POST, "category", FILTER_SANITIZE_NUMBER_INT);
//$role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_STRING);

if(empty($category)){
	exit("Please enter a class category");
}


$client->newClassCategory($category,$clientid,$userid);
    
}
else
{
    echo "Please submit a record";
}