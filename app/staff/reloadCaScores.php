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
//$manager = new manager($dbConnection);
$schid = $_SESSION['user_info'][4];
//$newStaff = new student();
$staffid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->staffUser($myroleid,$schid);

$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
   {
      //load subject scores after editing exam scores
      $class = filter_input(INPUT_POST, "myclass", FILTER_SANITIZE_STRING);
      $subject = filter_input(INPUT_POST, "subject", FILTER_SANITIZE_NUMBER_INT);
      

      //check for empty variable
        if(empty($class) || empty($subject))
        {
            exit("Please fill all the fields...");
        }else{
            //reload exams after edit
            $staff->reloadCa($class,$subject,$schid);
        }
   }
else
   {
    echo "Please submit a record";
   }
