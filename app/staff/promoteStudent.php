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
            $staff->promoteStudent($studentid,$recordid,$class,$session,$schid,$staffid);
        }
   }
else
   {
    echo "Please submit a record";
   }
