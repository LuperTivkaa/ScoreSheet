<?php
//session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
use Carbon\Carbon;

$dbConnection = new dbConnection();
$student = new student($dbConnection);
$client = new client($dbConnection);
$staff = new staff($dbConnection);
//use \PDO;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ScoreSheet| ACademic Settings</title>
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

                <div class="primary-col">
                        <div class="aux-menu">
                            <h6> Academic Settings Sub Menu</h6>
                            <ul>
                            <li><a class="load-url" href="academicTerm.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i> Term</a></li>
                            <li><a class="load-url" href="createSessions.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i> Session</a></li>
                            <li><a class="load-url" href="createSubjects.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i> Subject</a></li>
                            <li> <a class="load-url" href="createClass.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i> New Class</a></li>
                            <li> <a class="load-url" href="classCategory.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i> Class Category</a></li>
                            <li> <a class="load-url" href="scoreSettings.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i> Scores Settings</a></li>
                            <li><a class="load-url" href="setAdmissionNumber.php"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> New Numbers</a></li>
                            <li><a class="load-url" href="attendanceSettings.php"><i class="fa fa-calendar" aria-hidden="true"></i> Attendance Settings</a></li>
                            <li> <a class="load-url" href="createSkills.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i> Add Skills</a></li>
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