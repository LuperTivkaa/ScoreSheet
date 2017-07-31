<?php
//session_start();
include 'inc/regSession.php';
//get the user id of the staff logged in through the session variable
$staff_userid = $_SESSION['user_info'][0];
//school id based on the logged in user_info
$schid = $_SESSION['user_info'][4];

//Autoload classes
include'inc/autoload.php';
$client_module = new client();
$staff_module = new staff();
$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
   {
      //$regno = $_SESSION['ID'];
      $stud_regnumber = filter_input(INPUT_POST, "regno", FILTER_SANITIZE_STRING);
      $exam_scores = filter_input(INPUT_POST, "scores", FILTER_SANITIZE_NUMBER_INT);
      $studentClass = filter_input(INPUT_POST, "studentClass", FILTER_SANITIZE_NUMBER_INT);
      $studentClass_arm= filter_input(INPUT_POST, "class_Arm", FILTER_SANITIZE_NUMBER_INT);
      $subject = filter_input(INPUT_POST, "subject", FILTER_SANITIZE_NUMBER_INT);
      //check for empty variable
        if(empty($stud_regnumber) || empty($exam_scores) || empty($studentClass) || empty($studentClass_arm) || empty($subject))
        {
            exit("Please fill all the fields...");
        }else{
      //CALL METHOD TO ADD CA
      $staff_module->addTerminalExam($exam_scores,$stud_regnumber,$subject,$studentClass_arm,$staffid,$schid,$dateCreated);
        }
   }
else
   {
    echo "Please submit a record";
   }
