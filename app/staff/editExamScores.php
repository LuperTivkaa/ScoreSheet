<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
use ScoreSheet\jobmanager;
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
      $class = filter_input(INPUT_POST, "myclass", FILTER_SANITIZE_STRING);
      $subject = filter_input(INPUT_POST, "subject", FILTER_SANITIZE_NUMBER_INT);
      $scores = filter_input(INPUT_POST, "scores", FILTER_SANITIZE_NUMBER_INT);
      $examid= filter_input(INPUT_POST, "examid", FILTER_SANITIZE_STRING);

      //check for empty variable
        if(empty($scores) || empty($subject))
        {
            exit("Please fill all the fields...");
        }else{
            //edit exam scores
            $staff->editTerminalExam($scores,$subject,$class,$staffid,$examid,$schid);
        }
   }
else
   {
    echo "Please submit a record";
   }
