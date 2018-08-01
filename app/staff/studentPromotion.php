<?php
session_start();
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
$userid = $_SESSION['user_info'][0];

$myroleid = $_SESSION['user_info'][2];
$staff->staffUser($myroleid,$clientid);
?>

<!--Row  to hold some sub menu  -->
<div class="row">
                    <div class="col-md-12 mt-1">
                         <h5 class="top-header">Student Promotion</h6>
                        <div class="row">

                            <div class="col-6">
                            <label for="studentclass">Select Class</label>
                            <select class="custom-select  form-control" id="studentclass">
                              <?php
                                $client->loadClassTeacherClass($userid,$clientid);
                              ?>
                            </select>
                    </div>

                            <div class="col-6">
                            <label for="session">Session</label>
                            <select class="custom-select  form-control" id="session">
                                <?php
                                $staff->activeSession($clientid);
                                ?>
                            </select>
                            </div>
                            
                        </div> 
                        <div class="row"> 
                        <div class="col-6">
                    <button class="btn btn-primary mt-3" type="button" id="show-summary-result"><i class="fa fa-bars" aria-hidden="true"></i> Show Result Summary</button>
                            </div>
                            </div>
                    </div>
  </div>
<!-- Enter form to create new student here -->


      

           