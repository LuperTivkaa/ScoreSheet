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
    <title>ScoreSheet| School Student </title>
    <?php include '../inc/scoresheet-header.php';
    $clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->clientUser($myroleid,$clientid); 
    ?>

    <body>
        <div class="wrap">
            <?php include '../inc/scoresheet-user-profile.php';?>

            <?php include '../inc/scoresheet-school-profile.php';?>

            <?php include '../inc/scoresheet-nav-client.php';?>

            <div class="wrapper">
             <!-- The Modal -->
             <div id="myModal" class="modal-div">

                    <!-- Modal content -->
                    <div class="modal-content-div">
                        <span class="closex">&times;</span>

                    <div class="col-8">
                        <h6 class="top-header text-xs-center mt-3"><i class="fa fa-plus-circle" aria-hidden="true"></i>Student Photo Upload 
                        </h6>
                        <p class="display">
                           
                        </p>
                        <p id="modal_error"></p>  
                         
                       </div>
                        

                        <!--Begin session div  -->
                        <div class="upload-div">
                            <div class="col-8">
                            </div>

                            <div class="col-8">
                        <form id="form" action="studentPhotoProcess.php"  method="post" enctype="multipart/form-data">
                            <span>Please click on the camera icon to upload your photo</span>
                             
     
                                         <div class="form-group image-upload">
     
                                         <label for="student-file">
     
                                         <i class="fa fa fa-camera fa-5x"></i>
     
                                         </label>
                                 
                                         <input type="file" name="student-file" class="form-control" id="student-file">
     
                                         </div>
                                        
                        <input type="hidden" class="form-control" id="record-id" name="record-id">
                         </form>
                                        <div id="success-msg">
                                            <p id="msg"></p>
                                         </div>
                                         <div id="preview-img">
                                         
                                         </div>
                                         <div id="err">
                                         
                                         </div>
                            </div>

                            </div>
                            <input type="hidden" class="form-control" id="item-value" name="item-value">
                            <hr>
                            <div class="col-6" id="modal-list">
                            </div>
                            </div>

                    </div>
                <!--end new modal  -->

                <div class="primary-col">
                        <div class="aux-menu">
                            <h6> Admission  Sub Menu</h6>
                            <ul>
                            <li><a class="load-url" href="admissionList.php"><i class="fa fa-user fa-fw" aria-hidden="true"></i> Admission List</a></li>
                            <!-- <li><a class="load-url" href="studListByClass.php"><i class="fa fa-camera fa-fw" aria-hidden="true"></i> Upload Passport</a></li>
                            <li><a class="load-url" href="studentParent.php"><i class="fa fa-male fa-fw fa-fw" aria-hidden="true"></i>Add Parent</a></li> -->
                            <!-- <li><a class="load-url" href="studentGuardian.php"><i class="fa fa-male fa-fw fa-fw" aria-hidden="true"></i>Add Guardian</a></li>
                            <li><a class="load-url" href="createAdmissionNumber.php"><i class="fa fa-sort-numeric-asc fa-fw" aria-hidden="true"></i> Assign Admission Number</a></li>
                             <li><a class="load-url" href="student-list.php"><i class="fa fa-th-list fa-fw" aria-hidden="true"></i>Student's Preview</a></li>
                             <li><a class="load-url" href="student-search.php"><i class="fa fa-search fa-fw" aria-hidden="true"></i>Search Student</a></li> -->
                            </ul>   
                        </div>  
                   
                    <div id="my-info">
                    </div>
                     <!--You can put content here inside the primary column  -->

                    <!--end custom content  -->

                    <div id="new-content">
                    </div>
                    <div id="student-search-result">
                    </div>

                </div>

                <?php include '../inc/scoresheet-secondary-col.php';?>
            </div>
            <?php include '../inc/scoresheet-footer.php';?>
    </body>

</html>