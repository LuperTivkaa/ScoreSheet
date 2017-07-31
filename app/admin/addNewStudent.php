<?php
//session_start();
include 'inc/regSession.php';
$clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];
//function to generate unique number below
//Autoload classes
include'inc/autoload.php';
$mystudent = new student();
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



$mystudent->setSurname($surname);
$surn = $mystudent->getSurname();

$mystudent->setFirstname($firstname);
$fn = $mystudent->getFirstname();

$mystudent->setLastname($lastname);
$ln = $mystudent->getLastname();

$mystudent->setReligion($religion);
$rel = $mystudent->getReligion();

$mystudent->setCountry($nation);
$nation = $mystudent->getCountry();

$mystudent->setState($state);
$state = $mystudent->getState();

$mystudent->setLga($lg);
$lg = $mystudent->getLga();

$mystudent->setCity($city);
$city = $mystudent->getCity();

$mystudent->setAddress($add1);
$cont_add = $mystudent->getAddress();

$mystudent->setAddress($add2);
$perm_add = $mystudent->getAddress();

$mystudent->setEmail($mail);
$mail = $mystudent->getEmail();

$mystudent->setMobile($mobile);
$mobile = $mystudent->getMobile();

$mystudent->setGender($sex);
$sex = $mystudent->getGender();

$mystudent->setDob($dob);
$dob = $mystudent->getDob();

$mystudent->setBloodGroup($blood_group);
$blood = $mystudent->getBloodGroup();

$mystudent->newStudent($surn,$fn,$ln,$sex,$class_adm,$session,$adm_type,$arm,$dateCreated,
	$userid,$perm_add,$cont_add,$mail,$clientid,$nation,$state,$city,$lg,$rel,$dob,$mobile,$blood);
    
}
else
{
    echo "Please submit a record";
}