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
$client = new client($dbConnection);
$staff = new staff($dbConnection);
//$jobmanager = new manager($dbConnection);
$clientid = $_SESSION['user_info'][4];
//$newStaff = new student();
$userid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->clientUser($myroleid,$clientid);
?>

<!--Row  to hold some sub menu  -->
<div class="row">
                    <div class="col-md-12 mt-1">
                         <h5 class="top-header">Result Approval</h6>
                        <div class="row">

                            <div class="col-12">
                            <label for="s-class">Select Class</label>
                            <select class="custom-select  form-control" id="s-class">
                            <?php
                                $student->loadClass($clientid);
                              ?>
                            </select>
                            </div>


                            <div class="col-6">
                            <label for="s-session">Session</label>
                            <select class="custom-select  form-control" id="s-session">
                                <?php
                                $client->loadSession($clientid);
                                ?>
                            </select>
                            </div>

                            <div class="col-6">
                            <label for="s-term">Term</label>
                            <select class="custom-select  form-control" id="s-term">
                                <?php
                                $client->loadTerm($clientid);
                                ?>
                            </select>
                            </div>
                            
                        </div>  
                        <div class="row"> 
                        <div class="col-6">
                    <button class="btn btn-primary mt-3" type="button" id="result-approval"><i class="fa fa-database" aria-hidden="true"></i> Approve Result</button>
                            </div>
                            <div class="col-6">
                    <button class="btn btn-danger mt-3" type="button" id="reset-result-approval"><i class="fa fa-undo" aria-hidden="true"></i> Undo Result Approval</button>
                            </div>
                            </div>
                    </div>
  </div>
<!-- Enter form to create new student here -->


      

           