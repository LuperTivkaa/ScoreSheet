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
$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$stud_id = filter_input(INPUT_POST, "studid", FILTER_SANITIZE_NUMBER_INT);
$surname = filter_input(INPUT_POST, "sn", FILTER_SANITIZE_STRING);
$firstname = filter_input(INPUT_POST, "fn", FILTER_SANITIZE_STRING);
$lastname = filter_input(INPUT_POST, "ln", FILTER_SANITIZE_STRING);
$occupation = filter_input(INPUT_POST, "occup", FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING);
$mail = filter_input(INPUT_POST, "parentmail", FILTER_SANITIZE_EMAIL);
$mobile = filter_input(INPUT_POST, "mobile", FILTER_SANITIZE_NUMBER_INT);
$sex = filter_input(INPUT_POST, "sex", FILTER_SANITIZE_STRING);
$relationship = filter_input(INPUT_POST, "relationship", FILTER_SANITIZE_STRING);
$emergency = filter_input(INPUT_POST, "emergency", FILTER_SANITIZE_STRING);


$student->setSurname($surname);
$surn = $student->getSurname();

$student->setFirstname($firstname);
$fn = $student->getFirstname();

// $student->setLastname($lastname);
// $ln = $student->getLastname();

$student->setOccupation($occupation);
$occup = $student->getOccupation();

$student->setAddress($address);
$cont_add = $student->getAddress();

// $student->setEmail($mail);
// $mail = $student->getEmail();

// $student->setMobile($mobile);
// $mobile = $student->getMobile();

$student->setGender($sex);
$sex = $student->getGender();

$student->newParent($surn,$fn,$lastname,$occup,$sex,$cont_add,$mobile,$mail,$relationship,$stud_id,$clientid,$emergency);
    
}
else
{
    echo "Please submit a record";
}