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
                       <div class="col-md-5 mt-1">
                        <div class="row">

                          <div class="col-12">
                            <label for="ca-no">CA Number</label>
                            <select class="custom-select  form-control" id="ca-no">
                              <?php
                              $student->loadCASettings();
                              ?>
                            </select>
                            </div>

                        </div>
                       </div>

                    <div class="col-md-7 mt-1">
                        <div class="row">
                            

                        <div class="col-6">
                            <label for="assignmentclass">Select Class</label>
                            <select class="custom-select  form-control" id="assignmentclass">
                              <?php
                                $student->loadClass($clientid);
                              ?>
                            </select>
                            </div>
                            
                            <div class="col-6">
                            <label for="listsubject">Subject</label>
                            <select class="custom-select  form-control" id="listsubject">
                              <?php
                                $student->staffSubject($userid);
                              ?>
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
        <h6 class="top-header text-xs-center mt-3">Add CA Scores</h6>
        <div class="row">
          
          <div class="col-md-6">
                <label for="scores">Scores</label>
                <input type="text" class="form-control" id="scores" name="scores" placeholder="CA Scores">
            </div>

            <div class="col-md-6">
                <label for="regno">Reg Number</label>
                <input type="text" class="form-control" id="regno" name="regno" placeholder="Reg Number"> 
            </div>
              <span id="user_details">Display name of student here</span>
              <button class="submit btn btn-primary btn-md mt-3" id="add-ca">Enter Scores</button>

        </div>
      </div>

      <div class="col-md-2">
      </div>

</div>
<!--end row  -->

           