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
$staff->adminUser($myroleid,$schid);

$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
   {
      //$regno = $_SESSION['ID'];
      
      $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
    
      //check for empty variable
        if(empty($id))
        {
            exit("Please fill all the fields...");
        }else{
            //edit exam scores
            $client->deletePsychoSkillSettings($id,$schid);
        }
   }
else
   {
    echo "Please submit a record";
   }
