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
?>

              <!-- create fee items -->
              <div id="fee-item-container">

              <h5 class="top-header ">Attendance Settings</h5>
              <div class="row">

            <div class="form-group col-md-6">
            <label for="daysOpen">Total Days Open:</label>
                <input type="text" class="form-control" id="daysOpen" name="daysOpen" placeholder="Enter Days School Open ">
            </div>

            <div class="form-group col-md-6">
            <label for="daysClosed">Total Days Closed:</label>
                <input type="text" class="form-control" id="daysClosed" name="daysClosed" placeholder="Enter Days School Closed">
            </div>

            <div class="form-group col-md-6">
            <label for="term">Active Term:</label>
              <select class="custom-select form-control" id="term">
                <?php
                $staff->activeTerm($clientid);
                ?>
              </select>
            </div>

            <div class="form-group col-md-6">
            <label for="session">Active Session:</label>
              <select class="custom-select form-control" id="session">
                <?php
                $staff->activeSession($clientid);
                ?>
              </select>
            </div>

              
              </div>
              <div class="col-md-3">
              <button class="submit btn btn-primary" id="add-attendance-days">Add Settings</button>
              </div>

             
              <!-- <div class="row">
              <div class="col-md-12 mb-3">
              <h5 class="top-header text-xs-center mt-3">Specify Class Arm</h5><small>Select class and enter appropriate description. Click <i class="fa fa-refresh fa-fw reload-class" aria-hidden="true"></i> to load Classes.</small>
              </div>
              </div>

              <div class="row">

            <div class="form-group col-md-6">
                <label for="class-list">Select Class</label>
                <select class="custom-select form-control" id="class-list">
                </select>
              </div>

              <div class="form-group col-md-6">
                
                 <label for="class-desc">Class Description</label>
                <input type="text" class="form-control" id="class-desc" name="class-desc" placeholder="E.g Alpha or A">
              </div>
              
              </div>
              <button class="submit btn btn-primary" id="assign-desc">Assign Class Description</button>
            </div> -->