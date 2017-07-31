<?php
//THIS SCRIPT ASSIGNS NEW ADMISSION NUMBERS TO NEWLY ADDED STUDENTS
//session_start();
include 'inc/regSession.php';
//client id is the school id
$clientid = $_SESSION['user_info'][4];
//function to generate unique number below
//Autoload classes
include'inc/autoload.php';
$myStudent = new student();
$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$student_id = filter_input(INPUT_POST, "studid", FILTER_SANITIZE_STRING);
$adm_no_id = filter_input(INPUT_POST, "admno", FILTER_SANITIZE_STRING);


// $client->setUserName($username);
// $user = $client->getUserName();

// $client->setPassword($pass);
// $pass = $client->getPassword();

// $client->setRole($role);
// $role = $client->getRole();


$myStudent->assignNewNumber($student_id,$adm_no_id,$clientid);
    
}
else
{
    echo "Please submit a record";
}