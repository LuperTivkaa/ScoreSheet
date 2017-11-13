<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
use Carbon\Carbon;
//use \PDO;
$dbConnection = new dbConnection();
$client = new client($dbConnection);
$student = new student($dbConnection);
$staff = new staff($dbConnection);

$clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];
$roleid = $_SESSION['user_info'][2];
$staff->adminUser($roleid,$clientid);

$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
   {
      //$regno = $_SESSION['ID'];
        $classid = filter_input(INPUT_POST, "classid", FILTER_SANITIZE_NUMBER_INT);
        $class = filter_input(INPUT_POST, "schclass", FILTER_SANITIZE_STRING);
    //$term = filter_input(INPUT_POST, "term", FILTER_SANITIZE_NUMBER_INT);
      //$comment = filter_input(INPUT_POST, "staffcomment",FILTER_SANITIZE_STRING );
      
      //check for empty variable
        if(empty($class))
        {
          exit("Please fill all the fields...");
       }else{
            //edit class
            $client->editSchClass($classid,$class,$clientid);
        }
   }
else
   {
    echo "Please submit a record";
   }
