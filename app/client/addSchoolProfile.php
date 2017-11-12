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
//$jobmanager = new manager($dbConnection);
$clientid = $_SESSION['user_info'][4];
//$newStaff = new student();
$userid = $_SESSION['user_info'][0];
$staff->clientUser($userid,$clientid);;
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$sch_name = filter_input(INPUT_POST, "inst_name", FILTER_SANITIZE_STRING);
$sch_category = filter_input(INPUT_POST, "inst_category", FILTER_SANITIZE_STRING);
$nation = filter_input(INPUT_POST, "nation", FILTER_SANITIZE_STRING);
$state = filter_input(INPUT_POST, "state", FILTER_SANITIZE_STRING);
$lg = filter_input(INPUT_POST, "lg", FILTER_SANITIZE_STRING);
$city = filter_input(INPUT_POST, "city", FILTER_SANITIZE_STRING);
$mobile = filter_input(INPUT_POST, "mobile", FILTER_SANITIZE_STRING);
$url = filter_input(INPUT_POST, "webAdd", FILTER_SANITIZE_URL);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$strtAdd = filter_input(INPUT_POST, "streetAdd", FILTER_SANITIZE_STRING);
$mailbox = filter_input(INPUT_POST, "mailAdd", FILTER_SANITIZE_STRING);


$client->setSchName($sch_name);
$schname = $client->getSchName();

$client->setSchType($sch_category);
$schtype = $client->getSchType();

$client->setCountry($nation);
$country = $client->getCountry();

$client->setState($state);
$state = $client->getState();

$client->setLga($lg);
$lga = $client->getLga();

$client->setCity($city);
$city = $client->getCity();


$client->setMobile($mobile);
$mobile = $client->getMobile();

$client->setEmail($email);
$email = $client->getEmail();

$client->setAddress($strtAdd);
$strtAdd = $client->getAddress();

$client->setAddress($mailbox);
$mailbox = $client->getAddress();



 if(empty($schname) || empty($state) || empty($lga) || empty($city) || empty($mobile) || empty($strtAdd))
        {
         exit("Please fill all the fields...");
       }else{
           $client->instProfile($schname,$schtype,$clientid,$country,$state,$lga,$city,$mobile,$url,$email,$strtAdd,$mailbox);
       }
    
}
else
{
    echo "Please submit a record";
}