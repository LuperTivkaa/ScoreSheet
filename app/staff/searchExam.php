<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
//use \PDO;
$dbConnection = new dbConnection();
$student = new student($dbConnection);
$client = new client($dbConnection);
$clientid = $_SESSION['user_info'][4];
//$newStaff = new student();
$clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];
?>

<!--Row  to hold some sub menu  -->
<div class="row">
                       <div class="col-md-4 mt-1">
                            <h5 class="top-header">Exams Basic Search</h5>
                        <div class="row">

                            <div class="col-12">
                                <div class="input-group">
                                <input type="text" class="form-control" id="tag" name="tag" placeholder="Search for CA...">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">Search Exams...</button>
                                </span>
                                </div>
                                <small id="emailHelp" class="form-text text-muted">You can search by ID or Surname.</small>
                            </div>

                        </div>
                       </div>

                    <div class="col-md-8 mt-1">
                         <h5 class="top-header">Exams Advanced Search</h5>
                        <div class="row">
                            
                            <div class="col-4">
                            <label for="tag">Select Subject</label>
                            <select class="custom-select  form-control" id="ca-no">
                            </select>
                            
                            </div>

                            <div class="col-4">
                            <label for="tag">Select Class</label>
                            <select class="custom-select  form-control" id="arm">
                            </select>
                            </div>
                            
                            <div class="col-4">
                                <label for="tag">Class Arm</label>
                            <select class="custom-select  form-control" id="arm">
                            </select>
                            </div>

                            <div class="col-4">
                            <label for="tag">Session</label>
                            <select class="custom-select  form-control" id="arm">
                            </select>
                            </div>

                            <div class="col-4">
                            <label for="tag">Term</label>
                            <select class="custom-select  form-control" id="arm">
                            </select>
                            </div>

                            <div class="col-4">
                            <label for="tag">Search Tag</label>
                            <input type="text" class="form-control" id="tag" name="tag" placeholder="Search for CA...">
                            </div>
                            <div class="col-4">
                            <button class="btn btn-primary mt-3" type="button">Search CA!</button>
                            </div>
                        </div>  
                    </div>
  </div>
<!--  -->
<!-- Enter form to create new student here -->


      

           