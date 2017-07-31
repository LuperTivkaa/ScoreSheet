<?php
//session_start();
include 'inc/regSession.php';
$clientid = $_SESSION['user_info'][4];
//function to generate unique number below
//Autoload classes
include'inc/autoload.php';
$mystudent = new student();
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


$mystudent->setSurname($surname);
$surn = $mystudent->getSurname();

$mystudent->setFirstname($firstname);
$fn = $mystudent->getFirstname();

$mystudent->setLastname($lastname);
$ln = $mystudent->getLastname();

$mystudent->setOccupation($occupation);
$occup = $mystudent->getOccupation();

$mystudent->setAddress($address);
$cont_add = $mystudent->getAddress();

$mystudent->setEmail($mail);
$mail = $mystudent->getEmail();

$mystudent->setMobile($mobile);
$mobile = $mystudent->getMobile();

$mystudent->setGender($sex);
$sex = $mystudent->getGender();

$mystudent->newParent($surn,$fn,$ln,$occup,$sex,$cont_add,$mobile,$mail,$relationship,$stud_id,$clientid,$emergency);
    
}
else
{
    echo "Please submit a record";
}