<?php
//session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
use ScoreSheet\printRoutines;
//use \PDO;
$dbConnection = new dbConnection();
$student = new student($dbConnection);
$staff = new staff($dbConnection);
$client = new client($dbConnection);
$print = new printRoutines($dbConnection);
$clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];

$staff->staff($userid,$clientid);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ScoreSheet | Result Sheet</title>
    <?php include '../inc/scoresheet-header.php';
    //$c = $_SESSION['user_info'][4];
//$newStaff = new student();
//$userid = $_SESSION['user_info'][0];
    ?>

<body>

<div class="result-content-wrapper">

    <div class="school-profile">
        <?php
        $print->schoolProfileHeader($clientid);
        ?>
    </div>
    <!--end school profile div  -->
    <div class="student-profile">
        <?php
        $staff->studentAvatar(2,2);
        ?>
        
        <!--end avatar  div-->
        <div class="profile-details">
            <?php
            $print->userScoresDetails(2,1,7,1,2);
            ?>

        </div>
    </div>

    <div class="result-details">
        <h5 class="top-header"> Result Summary </h5>
        <?php
           // $print->userScoresDetails(3,1,7,1,2);
            $print->resultDetails(2,1,1,7,2)
        ?>
    </div>

    <div class="cognitive-marks">
        <h5 class="top-header">Affective Domain</h5>
        <?php
        $print->resultAffectiveTraits(2,2);
        ?>
    </div>
    
    <div class="cognitive-marks">
        <h5 class="top-header">Psychomotor Domain</h5>
        <?php
        $print->resultPsychomotorSkills(2,2);
        ?>
    </div>

    <div class="comments-section">
        <h5 class="top-header"> Comments & Info</h5>
        <p>Display in a list format, comments by staff and headteacher</p>
        <p>Display in a list format, signature and date by staff and headteacher</p>
        <p>Display in a list format, resumption date</p>
    </div>

</div>

</body>

</html>