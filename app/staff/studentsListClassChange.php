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
$schid = $_SESSION['user_info'][4];
//$newStaff = new student();
$staffid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->staffUser($myroleid,$schid);

$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
   //$regno = $_SESSION['ID'];
   
   $classid = filter_input(INPUT_POST, "classid", FILTER_SANITIZE_NUMBER_INT);
 
   //check for empty variable
     if(empty($classid))
     {
         exit("Please fill all the fields...");
     }else{
         //edit exam scores
         $client->studentListOnClass($schid,$classid);
     }
}
else
{
 echo "Please submit a record";
}


