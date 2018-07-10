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
//$newStaff = new student();
$userid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->staffUser($myroleid,$clientid);
?>

<!--Row  to hold some sub menu  -->
<div class="row">
                    <div class="col-md-12 mt-1">
                         <h5 class="top-header">View  Result(s)</h6>
                        <div class="row">

                            <div class="col-12">
                            <label for="studclass">Select Class</label>
                            <select class="custom-select  form-control" id="studclass">
                              <?php
                                $client->loadClassTeacherClass($userid,$clientid);
                              ?>
                            </select>
                    </div>

                            <div class="col-6">
                            <label for="session">Session</label>
                            <select class="custom-select  form-control" id="session">
                                <?php
                                $staff->ActiveSession($clientid);
                                ?>
                            </select>
                            </div>

                            <div class="col-6">
                            <label for="term">Term</label>
                            <select class="custom-select  form-control" id="term">
                                <?php
                                //$staff->ActiveTerm($clientid);
                            $client->loadTerm($clientid);
                                ?>
                            </select>
                            </div>
                            
                        </div> 
                        <div class="row"> 
                        <div class="col-6">
                    <button class="btn btn-primary mt-3" type="button" id="print-result"><i class="fa fa-print" aria-hidden="true"></i> Print Result</button>
                            </div>
                            </div>
                    </div>
  </div>
<!-- Enter form to create new student here -->


      

           