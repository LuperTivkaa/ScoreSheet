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
$clientid = $_SESSION['user_info'][4];
//$newStaff = new student();
$staffid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->staffUser($myroleid,$clientid);


if ($_SERVER["REQUEST_METHOD"]=="POST")
{
$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);

$staff->getStudent($id,$clientid);
}
else
{
echo "Please send some data";    
}

?>
