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
$client = new client($dbConnection);
$staff = new staff($dbConnection);
$schid = $_SESSION['user_info'][4];
//$newStaff = new student();
$staffid = $_SESSION['user_info'][0];
$staff->staff($staffid,$schid);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ScoreSheet| Academic Routines </title>
    <?php include '../inc/scoresheet-header.php';?>

    <body>
        <div class="wrap">
            <?php include '../inc/scoresheet-user-profile.php';?>

            <?php include '../inc/scoresheet-school-profile.php';?>

            <?php include '../inc/scoresheet-nav-staff.php';?>

            <div class="wrapper">
            
                    <!-- The Modal -->
                    <div id="myModal" class="modal-div">

                    <!-- Modal content -->
                    <div class="modal-content-div">
                        <span class="closex">&times;</span>

                        <div class="col-6">
                        <h6 class="top-header text-xs-center mt-3"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Examination Scores</h6>
                        </div>
                         <div class="col-6">
                            <label for="mystudentclass">Select Class</label>
                            <select class="custom-select  form-control" id="mystudentclass">
                              <?php
                                $student->loadClass($clientid);
                              ?>
                            </select>
                            </div>
                            
                            <div class="col-6">
                            <label for="mystudentsubject">Subject</label>
                            <select class="custom-select  form-control" id="mystudentsubject">
                            </select>
                            </div>

                                <div class="col-md-6">
                                <label for="edit-scores">Scores</label>
                                <input type="text" class="form-control" id="edit-scores" name="edit-scores">
                                </div>

                            <div class="col-6">
                                <button class="submit btn btn-primary btn-md mt-3 mb-3" id="edit-exam">Edit Scores</button>
                            </div>
                            <input type="hidden" class="form-control" id="record-id" name="record-id">
                            
                    </div>

                    </div>
                <!--end new modal  -->

           

                <div class="primary-col">
                       <!--bootstrap Container   -->
                   <div class="container">
            
                       <div class="row">
                       <!--Div to hold card for user profile  -->
                       <div class="col-md-12 pl-0">
                            <ul class="staff-menu">
                            <li><a class="load-url" href="createExam.php"><i class="fa fa-eraser fa-fw" aria-hidden="true"></i> New Exam Score</a></li>
                            <li><a class="load-url" href="searchExam.php"><i class="fa fa-search fa-fw" aria-hidden="true"></i> Search  Exam</a></li>
                             <li><a class="load-url" href="examSheet.php"><i class="fa fa-folder-o fa-fw" aria-hidden="true"></i> Exam Sheet</a></li>
                              <li><a class="load-url" href="processExams.php"><i class="fa fa-sort-numeric-asc fa-fw" aria-hidden="true"></i>Process Scores</a></li>

                             <li><a class="load-url" href="postResult.php"><i class="fa fa-upload fa-fw" aria-hidden="true"></i> Post Result</a></li>
                             
                            </ul>
                            <hr class="mt-2">                
                       </div>
                       <!--inner div  -->
                        </div> 
                           <!--row  -->
                           <div id="Staff-info">
                           </div>

                          <div id="my-info">
                          </div>

                          <div id="new-content">
                          </div>
                          
                        

                      </div>
                      <!--container  -->
                  <!--end bootstrap container  -->
                    
                </div>

                <?php include '../inc/scoresheet-secondary-col.php';?>
            </div>
            <?php include '../inc/scoresheet-footer.php';?>
    </body>

</html>