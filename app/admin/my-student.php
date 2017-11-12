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

$clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];
$staff->adminUser($userid,$clientid);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ScoreSheet| School Student </title>
    <?php include '../inc/scoresheet-header.php';?>

    <body>
        <div class="wrap">
            <?php include '../inc/scoresheet-user-profile.php';?>

            <?php include '../inc/scoresheet-school-profile.php';?>

            <?php include '../inc/scoresheet-nav.php';?>

            <div class="wrapper">

                <div class="primary-col">
                        <div class="aux-menu">
                            <h6> My Student Sub Menu</h6>
                            <ul>
                            <li><a class="load-url" href="newStudent.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i> New Student</a></li>
                            <li><a class="load-url" href="studentPhoto.php"><i class="fa fa-camera fa-fw" aria-hidden="true"></i> Upload Passport</a></li>
                            <li><a class="load-url" href="studentParent.php"><i class="fa fa-male fa-fw fa-fw" aria-hidden="true"></i>Add Parent</a></li>
                            <li><a class="load-url" href="studentGuardian.php"><i class="fa fa-male fa-fw fa-fw" aria-hidden="true"></i>Add Guardian</a></li>
                            <li><a class="load-url" href="createAdmissionNumber.php"><i class="fa fa-sort-numeric-asc fa-fw" aria-hidden="true"></i> Assign Admission Number</a></li>
                             <li><a class="load-url" href="student-list.php"><i class="fa fa-th-list fa-fw" aria-hidden="true"></i>Student's Preview</a></li>
                             <li><a class="load-url" href="student-search.php"><i class="fa fa-search fa-fw" aria-hidden="true"></i>Search Student</a></li>
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