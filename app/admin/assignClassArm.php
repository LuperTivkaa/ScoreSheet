<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use Carbon\Carbon;
//use \PDO;
$dbConnection = new dbConnection();
$client = new client($dbConnection);
$student = new student($dbConnection);

$clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];
//$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$class_descr = filter_input(INPUT_POST, "class_descr", FILTER_SANITIZE_STRING);
$class_id = filter_input(INPUT_POST, "class_id", FILTER_SANITIZE_STRING);
//$role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_STRING);

if(empty($class_descr || $class_id)){
	exit("Please provide a class description!");
}

$client->assignClassArm($class_descr,$class_id);
    
}
else
{
    echo "Please submit a record";
}