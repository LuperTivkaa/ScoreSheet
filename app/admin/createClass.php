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

              <h5 class="top-header ">Create New Class</h5>
              <div class="row">

            <div class="form-group col-md-6">
            <label for="class-name">Class Name:</label>
                <input type="text" class="form-control" id="class-name" name="class-name" placeholder="E.g JSS1A or Primary 1 Gold">
            </div>

            <div class="form-group col-md-6">
            <label for="class-category">Class Category:</label>
                <select class="custom-select form-control" id="class-category">
                <?php
                $client->classCategory($clientid);
                ?>
                </select>
            </div>

              
              </div>
              <div class="col-md-3">
              <button class="submit btn btn-primary" id="add-new-class">Add New Class</button>
              </div>

              <hr>
             