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
$staff->adminUser($staffid,$schid);

$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
   {
      //$regno = $_SESSION['ID'];
     // $regno = filter_input(INPUT_POST, "regno", FILTER_SANITIZE_STRING);
      $myclass = filter_input(INPUT_POST, "myclass", FILTER_SANITIZE_NUMBER_INT);
      $subject = filter_input(INPUT_POST, "subject", FILTER_SANITIZE_NUMBER_INT);
      $session= filter_input(INPUT_POST, "session", FILTER_SANITIZE_STRING);
      $term = filter_input(INPUT_POST, "term", FILTER_SANITIZE_NUMBER_INT);

      //check for empty variable
        if(empty($subject))
        {
            exit("Please fill all the fields...");
        }else{
            
        $staff->advancedCaSearch($myclass,$subject,$session,$term,$schid);
        }
   }
else
   {
    echo "Please submit a record";
   }
