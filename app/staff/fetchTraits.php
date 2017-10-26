<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
//use \PDO;
$dbConnection = new dbConnection();
$student = new student($dbConnection);
$client = new client($dbConnection);
$clientid = $_SESSION['user_info'][4];
//$newStaff = new student();
$userid = $_SESSION['user_info'][0];

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
$class = filter_input(INPUT_POST, "myclass", FILTER_SANITIZE_NUMBER_INT);
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