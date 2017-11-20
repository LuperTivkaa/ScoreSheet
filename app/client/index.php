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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ScoreSheet| Admin </title>
    <?php include '../inc/scoresheet-header.php';
    $clientid = $_SESSION['user_info'][4];
//$newStaff = new student();
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

                <!-- Intro content div  -->

                <div class="intro-content">
                  <!--conatiner  -->
                        <div class="container">

                            <div  class="row">

                                <div class="col-md-6">
                                <h6 class="top-header">Welcome, <?php echo  $_SESSION['user_info'][1];?>, You are super user! </h6>
                                <img src="../images/legacy2.png">

                                </div>

                                <div class="col-md-6">
                                <h6 class="top-header">Get Started...</h6>
                                <p>With scoresheet, we are here poised to drive you to a more productive workflow</p>

                                </div>

                            </div>

                        </div>
                        <!--end container  -->
                  </div>
                  <!-- End Intro content div  -->

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