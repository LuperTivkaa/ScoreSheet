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

$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
   {
      //$regno = $_SESSION['ID'];
      $searchitem = filter_input(INPUT_POST, "item", FILTER_SANITIZE_STRING);
    //   $ca_scores = filter_input(INPUT_POST, "scores", FILTER_SANITIZE_NUMBER_INT);
    //   $studentClass = filter_input(INPUT_POST, "studentClass", FILTER_SANITIZE_NUMBER_INT);
    //   $ca_number= filter_input(INPUT_POST, "ca_number", FILTER_SANITIZE_STRING);
    //   $subject = filter_input(INPUT_POST, "subject", FILTER_SANITIZE_NUMBER_INT);

      //check for empty variable
        if(empty($searchitem))
        {
            exit("Please fill all the fields...");
        }else{
            
        $staff->searchCa($searchitem,$clientid);
        }
   }
else
   {
    echo "Please submit a record";
   }
