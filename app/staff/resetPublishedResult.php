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

$staffid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->staffUser($myroleid,$schid);
$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
   {
      
      //$subj = filter_input(INPUT_POST, "subj", FILTER_SANITIZE_NUMBER_INT);
      $myclass = filter_input(INPUT_POST, "myclass", FILTER_SANITIZE_NUMBER_INT);
      $session = filter_input(INPUT_POST, "session", FILTER_SANITIZE_NUMBER_INT);
      $term = filter_input(INPUT_POST, "term", FILTER_SANITIZE_NUMBER_INT);
      
      //check for empty variable
        if(empty($myclass) || empty($session)  || empty($term) )
        {
        exit("Please fill all the fields...");
        }
        else
        {
        //$subj,$term,$session,$myclass,$schid
        $staff->undoPublishFinalResult($myclass,$term,$session,$schid);
        }
   }
else
   {
    echo "Please submit a record";
   }
