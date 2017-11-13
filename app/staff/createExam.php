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

$clientid = $_SESSION['user_info'][4];
//$newStaff = new student();
$userid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->staffUser($myroleid,$clientid);
?>

<!--Row  to hold some sub menu  -->
<div class="row">
                       

                    <div class="col-md-12 mt-1">
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
                        </div>  
                    </div>
  </div>
<!--  -->
<!-- Enter form to create new student here -->


        <!-- ADD NEW CA-->
    <div class="row">
      <div class="col-md-2">
      </div>

      <div class="col-md-8">
        <h6 class="top-header text-xs-center mt-3">Add Examination Scores</h6>
        <div class="row">
          
          <div class="col-md-6">
                <label for="scores">Scores</label>
                <input type="text" class="form-control" id="scores" name="scores" placeholder="Exam Scores">
            </div>

            <div class="col-md-6">
                <label for="regno">Reg Number</label>
                <input type="text" class="form-control" id="regno" name="regno" placeholder="Reg Number"> 
            </div>
              <span id="user_details">Display name of student here</span>
              <button class="submit btn btn-primary btn-md mt-3" id="add-exam-scores">Enter Scores</button>

        </div>
      </div>

      <div class="col-md-2">
      </div>

</div>
<!--end row  -->

           