<?php
//session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
//use \PDO;
$dbConnection = new dbConnection();
$student = new student($dbConnection);
$staff = new staff($dbConnection);
$client = new client($dbConnection);
$clientid = $_SESSION['user_info'][4];
//$newStaff = new student();
$userid = $_SESSION['user_info'][0];
$staff->staff($userid,$clientid);
?>
<!-- Enter form to create new student here -->
<div class="row mb-3">
<!--<div class="col-md-3"></div>-->
    <div class="col-md-12"><h6 class="top-header text-xs-center mt-3">Previous Enrollemnt</h6></div>
<!--<div class="col-md-3"></div>-->

</div>
  
        
        <!-- ENROLL NEW STUDENT IN A CLASS -->
        <div class="row">

            <div class="form-group col-md-6">
                 <label for="enroll-class">Choose Class</label>
                <select class="custom-select form-control" id="enroll-class">
                    <?php
                    $client->loadClassTeacherClass($userid,$clientid);
                    ?>
                </select>
              </div>

             
              <div class="form-group col-md-6">
                
                 <label for="enroll-session">Session</label>
                <select class="custom-select form-control" id="enroll-session">
                <?php 
                   $client->loadSession($clientid);
                  ?>
                </select>
              </div>
              
              </div>
              <div class="col-md-6">
              <button class="submit btn btn-primary" id="find-enrolled-student">List Enrolled</button>
              <div>
             

            