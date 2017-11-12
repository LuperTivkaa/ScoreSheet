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
    <div class="col-md-12"><h6 class="top-header text-xs-center mt-3">New Enrollemnt</h6></div>
<!--<div class="col-md-3"></div>-->

</div>
  
        
        <!-- ENROLL NEW STUDENT IN A CLASS -->
        <div class="row">

            <div class="col-md-4">
                <label for="regno">Reg Number</label>
                <input type="text" class="form-control" id="regno" name="regno" placeholder="Reg Number">
                <span id="user_details">Student name</span> 
            </div>
             

            <div class="form-group col-md-3">
                 <label for="enroll-class">Choose Class</label>
                <select class="custom-select form-control" id="enroll-class">
                    <?php
                    $client->loadClassTeacherClass($userid,$clientid);
                    ?>
                </select>
              </div>

             
              <div class="form-group col-md-3">
                
                 <label for="enroll-session">Session</label>
                <select class="custom-select form-control" id="enroll-session">
                <?php 
                   $staff->activeSession($clientid);
                  ?>
                </select>
              </div>
              
              </div>
              <div class="col-md-3">
              <button class="submit btn btn-primary" id="enroll-student">Enroll Student</button>
              <div>

              <div class="row">
                  <div class="col-md-12 enrolled-stud-list mt-3">

                  </div>

              </div>

            