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
$staff = filter_input(INPUT_POST, "staff", FILTER_SANITIZE_NUMBER_INT);
$myclass = filter_input(INPUT_POST, "class_id", FILTER_SANITIZE_NUMBER_INT);
$subject = filter_input(INPUT_POST, "subj", FILTER_SANITIZE_NUMBER_INT);
if(empty($myclass))
{
  Exit("Please select a class");  
}
else{
$client->addSubject($subject,$myclass,$staff,$clientid,$dateCreated,$dateCreated,$userid);
    
}
}
else
{
    echo "Please submit a record";
}