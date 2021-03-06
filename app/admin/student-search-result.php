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

/*
This file is to work with both the normal student search as well as the advanced search functionality
1. check whether date, class, session, term variables exist and are not empty
2. redirect to the advanced block using the if else control structures
3. otherwise, execute the normal search result
*/
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
    $search_input =$_POST['searchvar'];
    if(is_numeric($search_input))
      {
        $searchvar = filter_var($search_input, FILTER_SANITIZE_NUMBER_INT);
      }
    elseif(is_string($search_input))
      {
        $searchvar = filter_var($search_input, FILTER_SANITIZE_STRING);
      }
        //$searchvar = filter_input(INPUT_POST, "searchvar", FILTER_SANITIZE_STRING);
        // $app->setPin($id);
        //$did = $app->getPin();
$staff->searchStudent($searchvar,$clientid);
}
else
{
echo "Please send some data";    
}

    
