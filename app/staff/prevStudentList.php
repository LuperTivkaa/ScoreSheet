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
      
      $prevClass = filter_input(INPUT_POST, "prevClass", FILTER_SANITIZE_NUMBER_INT);
      $prevSess = filter_input(INPUT_POST, "prevSession", FILTER_SANITIZE_NUMBER_INT);
    
      //check for empty variable
        if(empty($prevClass) && empty($prevSess))
        {
            exit("Please fill all the fields...");
        }else{
            //edit exam scores
            $client->classEnrollmentFilter($prevClass,$prevSess,$staffid,$schid);
        }
   }
else
   {
    echo "Please submit a record";
   }
