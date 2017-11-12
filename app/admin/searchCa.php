<?php
//session_start();
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
$staff->adminUser($userid,$clientid);
?>

<!--Row  to hold some sub menu  -->
<div class="row">
                       <div class="col-md-4 mt-1">
                            <h5 class="top-header">Basic Search</h5>
                        <div class="row">

                            <div class="col-12">
                                <div class="input-group">
                                <input type="text" class="form-control" id="stud-no" name="stud-no" placeholder="Search CA...">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" id="ca-basic-search">Search CA!</button>
                                </span>
                                </div>
                                <small id="hint" class="form-text text-muted">You can search by ID </small>
                            </div>

                        </div>
                       </div>

                    <div class="col-md-8 mt-1">
                         <h5 class="top-header">Advanced Search</h5>
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
                            <label for="position-subject">Select Subject</label>
                            <select class="custom-select  form-control" id="position-subject">
                            </select>
                            </div>

                            <div class="col-6">
                            <label for="ca-session">Session</label>
                            <select class="custom-select  form-control" id="ca-session">
                                <?php
                                $client->loadSession($clientid);
                                ?>
                            </select>
                            </div>

                            <div class="col-6">
                            <label for="ca-term">Term</label>
                            <select class="custom-select  form-control" id="ca-term">
                                <?php
                            $client->loadTerm($clientid);
                                ?>
                            </select>
                            </div>
                            <div class="col-4">
                            <button class="btn btn-primary mt-3" type="button" id="advanced-search-ca">Search CA!</button>
                            </div>
                        </div>  
                    </div>
  </div>
<!--  -->
<!-- Enter form to create new student here -->


      

           