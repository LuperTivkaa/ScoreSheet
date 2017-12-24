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

              <h5 class="top-header "><i class="fa fa-bars fa-fw" aria-hidden="true"></i>
 Admission List </h5>
              <div class="row">

            <div class="form-group col-md-6">
            <label for="class-adm">Class:</label>
            <select class="custom-select form-control" id="class-adm">
                <?php
                $client->loadClass($clientid);
                ?>
                </select>
            </div>

            <div class="form-group col-md-6">
            <label for="sess-adm">Class Category:</label>
                <select class="custom-select form-control" id="sess-adm">
                <?php
                $client->loadSession($clientid);
                ?>
                </select>
            </div>

              
              </div>
              <div class="col-md-3">
              <button class="submit btn btn-primary" id="adm-list"> Display List</button>
              </div>

              <hr>
             