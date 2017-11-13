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
      $termid = filter_input(INPUT_POST, "termid", FILTER_SANITIZE_NUMBER_INT);
    //   $session = filter_input(INPUT_POST, "session", FILTER_SANITIZE_NUMBER_INT);
    //   $term = filter_input(INPUT_POST, "term", FILTER_SANITIZE_NUMBER_INT);
      //$comment = filter_input(INPUT_POST, "staffcomment",FILTER_SANITIZE_STRING );
      
      //check for empty variable
        //if(empty($comment) || empty($id))
        //{
          ///  exit("Please fill all the fields...");
       // }else{
            //edit exam scores
            $client->deactivateTerm($termid,$clientid);
        //}
   }
else
   {
    echo "Please submit a record";
   }
