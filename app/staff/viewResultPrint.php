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
      
      $studclass = filter_input(INPUT_POST, "studclass", FILTER_SANITIZE_NUMBER_INT);
      $session = filter_input(INPUT_POST, "session", FILTER_SANITIZE_NUMBER_INT);
      $term = filter_input(INPUT_POST, "term", FILTER_SANITIZE_NUMBER_INT);
      
      //check for empty variable
        if(empty($studclass) || empty($session)  || empty($term) )
        {
        exit("Please fill all the fields...");
        }
        else
        {
        //CALL METHOD TO ADD CA
        $staff->viewResultSummary($studclass,$term,$session,$clientid);
        }
   }
else
   {
    echo "Please submit a record";
   }
