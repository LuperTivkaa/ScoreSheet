<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
//use \PDO;

$dbConnection = new dbConnection();
$client = new client($dbConnection);
$clientid = $_SESSION['user_info'][4];

//TODO: Create this  function in Client class
$client->allTerms($clientid);
    
