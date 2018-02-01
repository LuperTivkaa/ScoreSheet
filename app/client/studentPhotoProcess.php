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
$staff->adminUser($myroleid,$clientid);

if(isset($_FILES['file_0']))
{
    $files = array();

    $files = $_FILES['file_0'];
$studentid = filter_input(INPUT_POST, "record-id", FILTER_SANITIZE_NUMBER_INT);
    //call method
    $client->processStudentPhoto($studentid,$clientid,$files);
}else
    {
        exit("Please submit an image");

    }


?>