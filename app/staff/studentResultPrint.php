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
$client = new client($dbConnection);
$staff = new staff($dbConnection);
$print = new printRoutines($dbConnection);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ScoreSheet | Result Sheet</title>
    <?php include '../inc/scoresheet-header.php';
    $schid = $_SESSION['user_info'][4];
//$newStaff = new student();
$staffid = $_SESSION['user_info'][0];
    ?>

<body>

<div class="result-content-wrapper">

    <div class="school-profile">
        <?php
        $print->schoolProfileHeader($schid);
        ?>
    </div>
    <!--end school profile div  -->
    <div class="student-profile">
        <div class="student-avatar">
            <h5><img src="../images/avatar.jpg" alt="John" class="avatar-img"></h5>
        </div>
        <!--end avatar  div-->
        <div class="profile-details">
            <?php
            $print->userScoresDetails(2,1,7,1,2);
            ?>

        </div>
    </div>

    <div class="result-details">
        <h5 class="top-header"> Result Summary </h5>
        <p>This div will contain result displayed in a tabular format</p>
    </div>

    <div class="cognitive-marks">
        <h5 class="top-header"> Cognitive & Psychomotor Domain</h5>
        <p>This div will contain cognitive and psychomotor skills</p>
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