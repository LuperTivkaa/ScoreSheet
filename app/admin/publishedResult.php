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

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
$classid = filter_input(INPUT_POST, "studentclass", FILTER_SANITIZE_NUMBER_INT);
$session = filter_input(INPUT_POST, "session", FILTER_SANITIZE_NUMBER_INT);
$term = filter_input(INPUT_POST, "term", FILTER_SANITIZE_NUMBER_INT);
// $app->setPin($id);
// $did = $app->getPin();
$staff->findPublishedResult($classid,$clientid);
}
else
{
echo "Please send some data";    
}

?>
