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
$schid = $_SESSION['user_info'][4];
//$newStaff = new student();
$staffid = $_SESSION['user_info'][0];
$staff->staff($staffid,$schid);

$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
   {
      //$regno = $_SESSION['ID'];
      $stud_regnumber = filter_input(INPUT_POST, "regno", FILTER_SANITIZE_STRING);
      $ca_scores = filter_input(INPUT_POST, "scores", FILTER_SANITIZE_NUMBER_INT);
      $studentClass = filter_input(INPUT_POST, "studentClass", FILTER_SANITIZE_NUMBER_INT);
      $ca_number= filter_input(INPUT_POST, "ca_number", FILTER_SANITIZE_STRING);
      $subject = filter_input(INPUT_POST, "subject", FILTER_SANITIZE_NUMBER_INT);

      //check for empty variable
        if(empty($stud_regnumber) || empty($ca_scores) || empty($studentClass) || empty($subject))
        {
            exit("Please fill all the fields...");
        }else{
            //CALL METHOD TO ADD CA
        $staff->addCa($ca_scores,$stud_regnumber,$subject,$studentClass,$staffid,$ca_number,$schid,$dateCreated);
        }
   }
else
   {
    echo "Please submit a record";
   }
