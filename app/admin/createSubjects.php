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
//echo $clientObj->loadStaff($clientid);
?>

              <!-- create fee items -->
              <div id="fee-item-container">

              <h5 class="top-header">Create New Subject</h5>
              <div class="row">

            <div class="form-group col-md-12">
            <label for="subject">Subject Name:</label>
                <input type="text" class="form-control" id="subject" name="subject" placeholder="E.g Mathemtics">
            </div>

              
              </div>
              <button class="submit btn btn-primary" id="add-new-subject">Add New Subject</button>

              <hr>
              <div class="row">
              <div class="col-md-12 mb-3">
              <h5 class="top-header text-xs-center mt-3">Add Subject to Class Category</h5><small>Select subject and specify class to add subject to. Click <i class="fa fa-refresh fa-fw reload" aria-hidden="true"></i> to load subjects.</small>
              </div>
              </div>

              <div class="row">

            <div class="form-group col-md-6">
                <label for="subject-list">Select Subject</label>
                <select class="custom-select form-control" id="subject-list">
                </select>
            </div>

              <div class="form-group col-md-6">
                
                 <label for="class-category">Select Class Category</label>
                <select class="custom-select form-control" id="class-category">
                <?php 
                    $client->classCategory($clientid);
                  ?>
                </select>
              </div>
              
              </div>
              <button class="submit btn btn-primary" id="assign-subject">Add Subject Category</button>
            </div>