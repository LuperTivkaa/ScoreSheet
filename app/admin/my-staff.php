<?php
//session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
use Carbon\Carbon;
//use \PDO;
$dbConnection = new dbConnection();
$client = new client($dbConnection);
$student = new student($dbConnection);
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
$roleid = $_SESSION['user_info'][2];
$staff->adminUser($roleid,$clientid);
    ?>

    <body>
        <div class="wrap">
            <?php include '../inc/scoresheet-user-profile.php';?>

            <?php include '../inc/scoresheet-school-profile.php';?>

            <?php include '../inc/scoresheet-nav.php';?>

            <div class="wrapper">

                <div class="primary-col">
                        <div class="aux-menu">
                            <h6> Staff Settings Sub Menu</h6>
                            <ul>
                            <li><a class="load-url" href="newStaff.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>New Staff</a></li>
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