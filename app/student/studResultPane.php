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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ScoreSheet| Academic Routines </title>
    <?php include '../inc/scoresheet-header.php';
    $schid = $_SESSION['user_info'][4];
    $staffid = $_SESSION['user_info'][0];
    $myroleid = $_SESSION['user_info'][2];
    $staff->staffUser($myroleid,$schid);
    ?>

    <body>
        <div class="wrap">
            <?php include '../inc/scoresheet-user-profile.php';?>

            <?php include '../inc/scoresheet-school-profile.php';?>

            <?php include '../inc/scoresheet-nav-student.php';?>

            <div class="wrapper">
                  <!-- The Modal -->
                    <div id="myModal" class="modal-div">

                    <!-- Modal content -->
                    <div class="modal-content-div">
                        <span class="closex">&times;</span>

                        <div class="col-6">
                        <h6 class="top-header text-xs-center mt-3"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Assessment Scores</h6>
                        <p id="modal_error"></p>
                        </div>
                        
                         <div class="col-6">
                            <label for="mystudentclass">Select Class</label>
                            <select class="custom-select  form-control" id="mystudentclass">
                              <?php
                                $client->loadClass($clientid);
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
                                <button class="submit btn btn-primary btn-md mt-3 mb-3" id="edit-ca">Edit Scores</button>
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
                            <li><a class="load-url" href="findMyResult.php"><i class="fa fa-eraser fa-fw" aria-hidden="true"></i> Find Result</a></li>
                            <li><a class="load-url" href="viewMyResult.php"><i class="fa fa-bolt fa-fw" aria-hidden="true"></i> View</a></li>
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
                    <!-- Modal -->
                            <div class="modal fade" id="myyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    ...
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                                </div>
                            </div>
                            </div>
                        <!--End modal  -->

                </div>

                <?php include '../inc/scoresheet-secondary-col.php';?>
            </div>
            <?php include '../inc/scoresheet-footer.php';?>
    </body>

</html>