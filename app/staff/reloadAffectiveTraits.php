<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
use ScoreSheet\manager;
//use \PDO;
$dbConnection = new dbConnection();
$student = new student($dbConnection);
$client = new client($dbConnection);
$staff = new staff($dbConnection);
//$manager = new manager($dbConnection);
$schid = $_SESSION['user_info'][4];
//$newStaff = new student();
$staffid = $_SESSION['user_info'][0];

$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
   {
      //load subject scores after editing exam scores
      $studentid = filter_input(INPUT_POST, "studentid", FILTER_SANITIZE_STRING);
      
        //check for empty variable
        if(empty($studentid))
        {
            exit("Please fill all the fields...");
        }else{
            //reload exams after edit
            $staff->reloadAffectiveTraits($studentid,$schid);
        }
   }
else
   {
    echo "Please submit a record";
   }
