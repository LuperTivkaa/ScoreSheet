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
$myroleid = $_SESSION['user_info'][2];
$staff->clientUser($myroleid,$clientid);

$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
   {
      //$regno = $_SESSION['ID'];
        $prefixid = filter_input(INPUT_POST, "prefixid", FILTER_SANITIZE_NUMBER_INT);
        $prefix = filter_input(INPUT_POST, "prefix", FILTER_SANITIZE_STRING);
    //$term = filter_input(INPUT_POST, "term", FILTER_SANITIZE_NUMBER_INT);
      //$comment = filter_input(INPUT_POST, "staffcomment",FILTER_SANITIZE_STRING );
      
      //check for empty variable
        if(empty($prefix))
        {
          exit("Please fill all the fields...");
       }else{
            //edit class
            $client->editSchPrefixSettings($prefixid,$prefix,$clientid);
        }
   }
else
   {
    echo "Please submit a record";
   }
