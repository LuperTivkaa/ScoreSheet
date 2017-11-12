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
//$jobmanager = new manager($dbConnection);
$schid = $_SESSION['user_info'][4];
//$newStaff = new student();
$staffid = $_SESSION['user_info'][0];
$staff->adminUser($staffid,$schid);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ScoreSheet| ACademic Settings</title>
    <?php include '../inc/scoresheet-header.php';?>

    <body>
        <div class="wrap">
            <?php include '../inc/scoresheet-user-profile.php';?>

            <?php include '../inc/scoresheet-school-profile.php';?>

            <?php include '../inc/scoresheet-nav.php';?>

            <div class="wrapper">

                <div class="primary-col">
                        <div class="aux-menu">
                            <h6> Academic Settings Sub Menu</h6>
                            <ul>
                            <li><a class="load-url" href="academicTerm.php"><i class="fa fa-paper-plane fa-fw" aria-hidden="true"></i>Term</a></li>
                            <li><a class="load-url" href="createSessions.php"><i class="fa fa-bolt fa-fw" aria-hidden="true"></i>Sessions</a></li>
                            <li><a class="load-url" href="mySessions.php"><i class="fa fa-bars fa-fw" aria-hidden="true"></i> All Sessions</a></li>
                            <li><a class="load-url" href="createSubjects.php"><i class="fa fa-paperclip fa-fw" aria-hidden="true"></i> Subject</a></li>
                            <li> <a class="load-url" href="createClass.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i> New Class</a></li>
                            <li> <a class="load-url" href="classCategory.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i> Class Category</a></li>
                            <li> <a class="load-url" href="ScoreSettings.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i> Scores Settings</a></li>
                            <li><a class="load-url" href="setAdmissionNumber.php"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> New Numbers</a></li>
                            <li><a class="load-url" href="attendanceSettings.php"><i class="fa fa-calendar" aria-hidden="true"></i> Attendance Settings</a></li>
                            <li><a class="load-url" href="nextTerm.php"><i class="fa fa-calendar" aria-hidden="true"></i> Resumption</a></li>

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