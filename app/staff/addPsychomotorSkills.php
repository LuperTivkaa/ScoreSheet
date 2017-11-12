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
$staff->staff($staffid,$schid);

$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
   {
      //$regno = $_SESSION['ID'];
      $domain_item = filter_input(INPUT_POST, "mydomain", FILTER_SANITIZE_STRING);
      $rating = filter_input(INPUT_POST, "grading", FILTER_SANITIZE_NUMBER_INT);
      $studentid = filter_input(INPUT_POST, "studentid", FILTER_SANITIZE_NUMBER_INT);

      //check for empty variable
        if(empty($domain_item) || empty($rating))
        {
            exit("Please fill all the fields...");
        }else{
            //edit exam scores
            $staff->newPsychomotorSkills($domain_item,$rating,$studentid,$schid,$staffid,$dateCreated);
        }
   }
else
   {
    echo "Please submit a record";
   }
