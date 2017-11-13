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
//$newStaff = new student();
$userid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->staffUser($myroleid,$clientid);

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
$classid = filter_input(INPUT_POST, "studentclass", FILTER_SANITIZE_NUMBER_INT);
$session = filter_input(INPUT_POST, "session", FILTER_SANITIZE_NUMBER_INT);
$term = filter_input(INPUT_POST, "term", FILTER_SANITIZE_NUMBER_INT);
// $app->setPin($id);
// $did = $app->getPin();
$staff->traits($classid,$clientid);
}
else
{
echo "Please send some data";    
}

?>
