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
$classid = filter_input(INPUT_POST, "myclass", FILTER_SANITIZE_NUMBER_INT);
$sessionid = filter_input(INPUT_POST, "session", FILTER_SANITIZE_NUMBER_INT);

if(empty($classid) || empty($sessionid))
{
    exit("Please all fields...");
}
  else{

 $client->admissionListByClass($classid,$sessionid,$clientid);
    
 }
}
else
{
    echo "Please submit a record";
}