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
    <title>ScoreSheet| Staff Settings </title>
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
                        <h6 class="top-header text-xs-center mt-3"><i class="fa fa-plus-circle" aria-hidden="true"></i>Edit Menu  
                        </h6>
                        <p class="display">
                           
                        </p>
                        <p id="modal_error"></p>  
                         
                       </div>

                        <!--View Staff div -->
                        <div class="viewStaff-div">
                           
                        </div>
                        <!--End view Staff-->

                            <input type="hidden" class="form-control" id="record-id" name="record-id">
                            <input type="hidden" class="form-control" id="item-value" name="item-value">
                            <hr>
                            <div class="col-6" id="modal-list">
                            </div>
                            </div>

                    </div>
                <!--end new modal  -->

                <div class="primary-col">
                        <div class="aux-menu">
                            <h6> Staff Settings Sub Menu</h6>
                            <ul>
                            <li><a class="load-url" href="newStaff.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>New Staff</a></li>
                            <li><a class="load-url" href="approveStaff.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>Approve Staff</a></li>
                            <li><a class="load-url" href="createStaffSubjects.php"><i class="fa fa-clone fa-fw" aria-hidden="true"></i>Assign Subject(s)</a></li>
                            <li><a class="load-url" href="classTeacher.php"><i class="fa fa-briefcase" aria-hidden="true"></i>Assign Class Teacher</a></li>
                            <li><a class="my-staff" href="male.php"><i class="fa fa-male fa-fw" aria-hidden="true"></i>Staff</a></li>
                            <li><a class="my-staff" href="female.php"><i class="fa fa-female fa-fw" aria-hidden="true"></i> Staff</a></li>
                            </ul>   
                        </div>  
                    <!--You can put content here inside the primary column  -->

                    <!--end custom content  -->
                    <div id="my-info">
                    </div>

                    <div id="new-content">
                    </div>

                </div>

                <?php include '../inc/scoresheet-secondary-col.php';?>
            </div>
            <?php include '../inc/scoresheet-footer.php';?>
    </body>

</html>