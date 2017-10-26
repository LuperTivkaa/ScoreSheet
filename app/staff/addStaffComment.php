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

$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
   {
      //$regno = $_SESSION['ID'];
      $studentid = filter_input(INPUT_POST, "studentid", FILTER_SANITIZE_NUMBER_INT);
      $comment = filter_input(INPUT_POST, "staffcomment",FILTER_SANITIZE_STRING );
      

      //check for empty variable
        if(empty($comment) || empty($studentid))
        {
            exit("Please fill all the fields...");
        }else{
            //edit exam scores
            $staff->newStaffComment($studentid,$comment,$schid);
        }
   }
else
   {
    echo "Please submit a record";
   }
