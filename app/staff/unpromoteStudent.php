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
$staff = new staff($dbConnection);
$client = new client($dbConnection);
$clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];

$myroleid = $_SESSION['user_info'][2];
$staff->staffUser($myroleid,$clientid);

$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
   {
      //$regno = $_SESSION['ID'];
      $recordid = filter_input(INPUT_POST, "recordid", FILTER_SANITIZE_NUMBER_INT);
      $class = filter_input(INPUT_POST, "promotedClass", FILTER_SANITIZE_NUMBER_INT);
      $session = filter_input(INPUT_POST, "promotedSess", FILTER_SANITIZE_NUMBER_INT);
      $studentid = filter_input(INPUT_POST, "studentid", FILTER_SANITIZE_NUMBER_INT);
      
      //check for empty variable
        if(empty($recordid) || empty($class) || empty($session) || empty($studentid))
        {
        exit("Please fill all the fields...");
       }else{
            //promote student
            $staff->unpromoteStudent($studentid,$recordid,$class,$session,$clientid,$userid);
        }
   }
else
   {
    echo "Please submit a record";
   }
