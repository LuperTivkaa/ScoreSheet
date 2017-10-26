<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\staff;
use ScoreSheet\student;

//use \PDO;

$dbConnection = new dbConnection();
$student = new student($dbConnection);
$client = new client($dbConnection);
$clientid = $_SESSION['user_info'][4];
$staffid = $_SESSION['user_info'][0];

//TODO: Create this  function in Client class
$client->allClasses($clientid);
    
