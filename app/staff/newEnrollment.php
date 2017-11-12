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
$staff->staff($staffid,$schid);
$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
   {
      
      $enrollregno = filter_input(INPUT_POST, "enrollregno", FILTER_SANITIZE_NUMBER_INT);
      $myclass = filter_input(INPUT_POST, "myclass", FILTER_SANITIZE_NUMBER_INT);
      $session = filter_input(INPUT_POST, "session", FILTER_SANITIZE_NUMBER_INT);

      
      //check for empty variable
        if(empty($enrollregno) )
        {
        exit("Please fill all the fields...");
        }
        else
        {
        //new student enrollment
        $staff->enrollStudent($enrollregno,$myclass,$session,$staffid,$schid,$dateCreated);
        }
   }
else
   {
    echo "Please submit a record";
   }
