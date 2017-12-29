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
$staff = new staff($dbConnection);
$client = new client($dbConnection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ScoreSheet| Staff </title>
    <?php include '../inc/scoresheet-header.php';
    $clientid = $_SESSION['user_info'][4];
    //$newStaff = new student();
    $userid = $_SESSION['user_info'][0];
    $myroleid = $_SESSION['user_info'][2];
    $staff->staffUser($myroleid,$clientid);
    ?>

    <body>
        <div class="wrap">
            <?php include '../inc/scoresheet-user-profile.php';?>

            <?php include '../inc/scoresheet-school-profile.php';?>

            <?php include '../inc/scoresheet-nav-staff.php';?>

            <div class="wrapper">

                <div class="primary-col">
                       <!--bootstrap Container   -->
                   <div class="container">
            
                       <div class="row">
                       <!--Div to hold card for user profile  -->
                       <!-- <div class="col-md-4">
                                <?php 
                                //$staff->staffProfileCard($clientid,$userid);
                                ?>
                       </div> -->

                       <div class="col-md-12">
                            <ul class="staff-menu">
                            <li><a class="load-url" href="newStaff.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i> New Profile</a></li>
                            <li><a class="load-url" href="staffPhoto.php"><i class="fa fa-camera fa-fw" aria-hidden="true"></i> Upload Photo</a></li>
                            <li><a class="load-url" href="staffQualification.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i> Academic Qualifications</a></li>
                             <li><a class="load-url" href="staff-preview.php"><i class="fa fa-eye fa-fw" aria-hidden="true"></i> Profile Preview</a></li>
                            </ul>
                            <hr class="mt-2">
                       <div id="Staff-info">
                       </div>
                       <div id="my-info">
                        </div>

                        <div id="new-content">
                        </div>

                        <div id="qualification-content">
                        </div>
                       </div>

                        </div>
                      </div>
                  <!--end bootstrap container  -->
                    

                </div>

                <?php include '../inc/scoresheet-secondary-col.php';?>
            </div>
            <?php include '../inc/scoresheet-footer.php';?>
    </body>

</html>