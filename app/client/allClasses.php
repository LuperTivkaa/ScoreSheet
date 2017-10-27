<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
//use \PDO;

$dbConnection = new dbConnection();
$client = new client($dbConnection);
$clientid = $_SESSION['user_info'][4];
$client->loadClass($clientid);

?>
