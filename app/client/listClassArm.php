<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
//use \PDO;
$dbConnection = new dbConnection();
$client = new client($dbConnection);
$student = new student($dbConnection);

$clientid = $_SESSION['user_info'][4];

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
$student->loadClassArm($id);
}
else
{
echo "Please send some data";    
}

?>
