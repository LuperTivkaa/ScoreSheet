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
                       <div class="col-md-4 mt-1">
                            <h5 class="top-header">Exams Basic Search</h5>
                        <div class="row">

                            <div class="col-12">
                                <div class="input-group">
                                <input type="text" class="form-control" id="basic-search-item" name="basic-search-item" placeholder="Search Exam">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" id="simple-search">Search Exams</button>
                                </span>
                                </div>
                                <small id="search-term" class="form-text text-muted">You can search by ID.</small>
                            </div>

                        </div>
                       </div>

                    <div class="col-md-8 mt-1">
                         <h5 class="top-header">Exams Advanced Search</h5>
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
                            <label for="exam-session">Session</label>
                            <select class="custom-select  form-control" id="exam-session">
                                <?php
                                $client->loadSession($clientid);
                                ?>
                            </select>
                            </div>

                            <div class="col-6">
                            <label for="exam-term">Term</label>
                            <select class="custom-select  form-control" id="exam-term">
                                <?php
                            $client->loadTerm($clientid);
                                ?>
                            </select>
                            </div>

                            <!-- <div class="col-4">
                            <label for="reg-number">Search Tag</label>
                            <input type="text" class="form-control" id="reg-number" placeholder="Reg Number">
                            </div> -->
                            <div class="col-4">
                            <button class="btn btn-primary mt-3" type="button" id="advanced-search">Search Exam</button>
                            </div>
                        </div>  
                    </div>
  </div>
<!--  -->
<!-- Enter form to create new student here -->


      

           