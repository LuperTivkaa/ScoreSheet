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
$staff->clientUser($userid,$clientid);

$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$surname = filter_input(INPUT_POST, "surname", FILTER_SANITIZE_STRING);
$firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_STRING);
$lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_STRING);
$religion = filter_input(INPUT_POST, "religion", FILTER_SANITIZE_STRING);
$nation = filter_input(INPUT_POST, "nation", FILTER_SANITIZE_NUMBER_INT);
$state = filter_input(INPUT_POST, "state", FILTER_SANITIZE_NUMBER_INT);
$lg = filter_input(INPUT_POST, "lg", FILTER_SANITIZE_NUMBER_INT);
$city = filter_input(INPUT_POST, "city", FILTER_SANITIZE_NUMBER_INT);
$add1 = filter_input(INPUT_POST, "add1", FILTER_SANITIZE_STRING);
$add2 = filter_input(INPUT_POST, "add2", FILTER_SANITIZE_STRING);
$mail = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL);
$mobile = filter_input(INPUT_POST, "mobile", FILTER_SANITIZE_STRING);
$sex = filter_input(INPUT_POST, "sex", FILTER_SANITIZE_STRING);
$dob = filter_input(INPUT_POST, "dob", FILTER_SANITIZE_STRING);
$blood_group = filter_input(INPUT_POST, "blood_group", FILTER_SANITIZE_STRING);
$class_adm = filter_input(INPUT_POST, "class_adm", FILTER_SANITIZE_NUMBER_INT);
$arm = filter_input(INPUT_POST, "arm", FILTER_SANITIZE_NUMBER_INT);
$session = filter_input(INPUT_POST, "session", FILTER_SANITIZE_NUMBER_INT);
$adm_type = filter_input(INPUT_POST, "adm_type", FILTER_SANITIZE_STRING);



$student->setSurname($surname);
$surn = $student->getSurname();

$student->setFirstname($firstname);
$fn = $student->getFirstname();

$student->setLastname($lastname);
$ln = $student->getLastname();

$student->setReligion($religion);
$rel = $student->getReligion();

$student->setCountry($nation);
$nation = $student->getCountry();

$student->setState($state);
$state = $student->getState();

$student->setLga($lg);
$lg = $student->getLga();

$student->setCity($city);
$city = $student->getCity();

$student->setAddress($add1);
$cont_add = $student->getAddress();

$student->setAddress($add2);
$perm_add = $student->getAddress();

$student->setEmail($mail);
$mail = $student->getEmail();

$student->setMobile($mobile);
$mobile = $student->getMobile();

$student->setGender($sex);
$sex = $student->getGender();

$student->setDob($dob);
$dob = $student->getDob();

$student->setBloodGroup($blood_group);
$blood = $student->getBloodGroup();

$student->newStudent($surn,$fn,$ln,$sex,$class_adm,$session,$adm_type,$arm,$dateCreated,
	$userid,$perm_add,$cont_add,$mail,$clientid,$nation,$state,$city,$lg,$rel,$dob,$mobile,$blood);
    
}
else
{
    echo "Please submit a record";
}