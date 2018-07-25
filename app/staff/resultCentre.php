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
//$manager = new manager($dbConnection);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ScoreSheet| Academic Routines </title>
    <?php include '../inc/scoresheet-header.php';
    $schid = $_SESSION['user_info'][4];
//$newStaff = new student();
$staffid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->staffUser($myroleid,$schid);
    ?>
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

                    <div class="col-8">
                        <h6 class="top-header text-xs-center mt-3"><i class="fa fa-plus-circle" aria-hidden="true"></i>Add Student Traits & Comments  
                        </h6>
                        <p class="display">
                            <button type="button" class="custom-btn" id="mydefault">Affective</button>
                            <button type="button" class="custom-btn" id="nondefault">Psychomotor</button>
                            <button type="button" class="custom-btn" id="studcomments">Comments</button>
                            <button type="button" class="custom-btn" id="attendancediv">Attendance</button>
                            
                            
                        </p>
                        <p id="modal_error"></p>  
                         
                    </div>

                        <!--Affective Domain  -->
                        <div class="affective-domain-div">

                            <div class="col-8">
                            <h6 class="highlight top-header text-xs-center mt-3">Affective Domain</h6>
                            </div>

                            <div class="col-8">
                            <label for="affective-domain">Select Domain</label>
                            <select class="custom-select  form-control" id="affective-domain">
                              <?php
                                $client->fetchAffectiveDomain($clientid);
                              ?>
                            </select>
                            </div>
                            
                            <div class="col-8">
                            <label for="affective-grading">Grading</label>
                            <select class="custom-select  form-control" id="affective-grading">
                                <?php
                                $client->fetchGrading();
                                ?>
                            </select>
                            </div>

                            <div class="col-4">
                        <button class="submit btn btn-primary btn-md mt-3 mb-3" id="add-affective-domain"><i class="fa fa-plus" aria-hidden="true"></i> Affective Domain</button>
                            </div>
                        </div>
                        <!--End affective div  -->
                        <!--Begin comments div  -->
                        
                        <div class="comments-div">
                            <div class="col-8">
                            <h6 class="highlight top-header text-xs-center mt-3">Add Comments</h6>
                            </div>

                            <div class="col-8">
                            <label for="comment-id">Enter comment</label>
                            <textarea class="form-control" id="comment-id" rows="2"></textarea>
                            <span id="textRemaining">20</span> Characters remaining
                            </div>
                            
                            <div class="col-4">
                        <button class="submit btn btn-primary btn-md mt-3 mb-3" id="add-comments"><i class="fa fa-plus" aria-hidden="true"></i> Add Comments</button>
                            </div>
                        </div>
                        <!--end comments div  -->
                        <!--Attendance div  -->
                        <div class="attendance-div">
                            <div class="col-8">
                            <h6 class="highlight top-header text-xs-center mt-3">Add Attendance</h6>
                            </div>

                            <div class="col-8">
                            <label for="days">Attendance Days</label>
                             <input type="text" class="form-control" id="days" name="days" placeholder="Days attended">
                            </div>
                            
                            <div class="col-4">
                        <button class="submit btn btn-primary btn-md mt-3 mb-3" id="add-attendance"><i class="fa fa-plus" aria-hidden="true"></i> Add Attendance </button>
                            </div>
                        </div>
                        <!--end comments div  -->
                        <!--End attendance div  -->
                        <!--Begin psychomotor skills  -->
                        <div class="psychomotor-domain-div">
                            <div class="col-8">
                            <h6 class="highlight top-header text-xs-center mt-3"> Psychomotor Domain</h6>
                            </div>

                            <div class="col-8">
                             <label for="psycho=skills">Select Psychomotor Skills</label>
                             <select class="custom-select  form-control" id="psycho-skills">
                              <?php
                                $client->fetchPsychomotor($clientid);
                              ?>
                             </select>
                             </div>

                             <div class="col-8">
                            <label for="psycho-grading">Grading</label>
                            <select class="custom-select  form-control" id="psycho-grading">
                                <?php
                                $client->fetchGrading();
                                ?>
                            </select>
                            </div>

                            <div class="col-4">
                            <button class="submit btn btn-primary btn-md mt-3 mb-3" id="add-psycho-skills"><i class="fa fa-plus" aria-hidden="true"></i> Psychomotor Skills</button>
                            </div>

                        </div>
                            <input type="hidden" class="form-control" id="record-id" name="record-id">
                            <input type="hidden" class="form-control" id="studclassid" name="studclassid">
                            <hr>
                            <div class="col-6" id="modal-list">
                            
                            </div>
                            
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
                            <li><a class="load-url" href="traits.php"><i class="fa fa-list"aria-hidden="true"></i> Add Cognitive Domain</a></li>
                    
                             <li><a class="load-url" href="resultSummary.php">
                             <i class="fa fa-sitemap" aria-hidden="true"></i> Comments Summary</a></li>

                        <li><a class="load-url" href="publishResult.php"><i class="fa fa-database" aria-hidden="true"></i>
 Publish Result</a></li>
   <li><a class="load-url" href="studentPromotion.php"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Promotions</a></li>
       <li><a class="load-url" href="printResult.php"><i class="fa fa-eye" aria-hidden="true"></i>
 View Result</a></li> 
                             
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