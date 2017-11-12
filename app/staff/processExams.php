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
$clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];
$staff->staff($userid,$clientid);
?>

<!--Row  to hold some sub menu  -->
<div class="row">
                    <div class="col-md-12 mt-1">
                         <h5 class="top-header">Process Subject Position</h6>
                        <div class="row">

                            <div class="col-6">
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

                            <div class="col-6">
                            <label for="term">Term</label>
                            <select class="custom-select  form-control" id="term">
                                <?php
                                $client->loadTerm($clientid);
                                ?>
                            </select>
                            </div>
                            
                        </div>  
                        <div class="col-6">
                            <button class="btn btn-primary mt-3" type="button" id="assign-position">Assign Subject Position</button>
                            </div>
                    </div>
  </div>
<!-- Enter form to create new student here -->


      

           