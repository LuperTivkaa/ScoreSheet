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
$clientid = $_SESSION['user_info'][4];
//$newStaff = new student();
$userid = $_SESSION['user_info'][0];
$staff->clientUser($userid,$clientid);

$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
   {
      //$regno = $_SESSION['ID'];
        $subjectid = filter_input(INPUT_POST, "subjectid", FILTER_SANITIZE_NUMBER_INT);
        $subject = filter_input(INPUT_POST, "subject", FILTER_SANITIZE_STRING);
      //$term = filter_input(INPUT_POST, "term", FILTER_SANITIZE_NUMBER_INT);
      //$comment = filter_input(INPUT_POST, "staffcomment",FILTER_SANITIZE_STRING );
      
      //check for empty variable
        if(empty($subject))
        {
       exit("Please fill all the fields...");
       }else{
            //edit school subject
            $client->editSchSubject($subjectid,$subject,$clientid);
        }
   }
else
   {
    echo "Please submit a record";
   }
