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

              <h5 class="top-header ">CA Scores Settings</h5>
              <div class="row">

            <div class="form-group col-md-6">
            <label for="ca-score">CA Score:</label>
                <input type="text" class="form-control" id="ca-score" name="ca-score" placeholder="Enter Max CA Score Eg 10">
            </div>

            <div class="form-group col-md-6">
            <label for="caclass-category">Class Category:</label>
              <select class="custom-select form-control" id="caclass-category">
                <?php
                $client->classCategory($clientid);
                ?>
              </select>
            </div>

              
              </div>
              <div class="col-md-3">
              <button class="submit btn btn-primary" id="ca-max-score">Add CA Score</button>
              </div>

              <hr>

               <h5 class="top-header ">Exam Score Settings</h5>
              <div class="row">

            <div class="form-group col-md-6">
            <label for="exam-score">Exam Score:</label>
                <input type="text" class="form-control" id="exam-score" name="exam-score" placeholder="Enter Max Scores Eg 60">
            </div>

            <div class="form-group col-md-6">
            <label for="examclass-category">Class Category:</label>
                <select class="custom-select form-control" id="examclass-category">
                <?php
                $client->classCategory($clientid);
                ?>
                </select>
            </div>

              
              </div>
              <div class="col-md-3">
              <button class="submit btn btn-primary" id="exam-max-score">Add Exam Score</button>
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