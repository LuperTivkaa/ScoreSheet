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
$clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->staffUser($myroleid,$clientid);
?>

<!--Row  to hold some sub menu  -->
<div class="row">
                    <div class="col-md-12 mt-1">
                         <h5 class="top-header">Assign Annual Subject Position</h6>
                        <div class="row">

                            <div class="col-12">
                            <label for="my-class">Select Class</label>
                            <select class="custom-select  form-control" id="my-class">
                              <?php
                                $student->loadClass($clientid);
                              ?>
                            </select>
                            </div>

                            <div class="col-6">
                            <label for="position-subject">Subject</label>
                            <select class="custom-select  form-control" id="position-subject">
                            </select>
                            </div>


                            <div class="col-6">
                            <label for="session">Session</label>
                            <select class="custom-select  form-control" id="session">
                                <?php
                                $client->loadSession($clientid);
                                ?>
                            </select>
                            </div>
                            
                        </div>  
                            <div class="row">
                            <div class="col-6">
                            <button class="btn btn-primary mt-3" type="button" id="assign-annual-subj-position">Assign Position</button>
                            </div>

                            <div class="col-6">
                            <button class="btn btn-success mt-3" type="button" id="reset-annual-subj-position"><i class="fa fa-sort-numeric-asc" aria-hidden="true"></i> Reset Position</button>
                            </div>

                            </div>
                    </div>
  </div>
<!-- Enter form to create new student here -->



      

           