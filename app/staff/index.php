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
    <title>ScoreSheet| Staff </title>
    <?php include '../inc/scoresheet-header.php';
    $clientid = $_SESSION['user_info'][4];
    //$newStaff = new student();
    $staffid = $_SESSION['user_info'][0];
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
                       

                      <p>Content here th hjhis  htyn ysjjs tjjs tjjs tjjsthj sttsjjs tj tjis thshs tjjs tjj tjsg tj shhsbbs s hs  hjjshfs kjkjfskjfhds kjnfkjdskjds kjnsjnfs kjnjfndsf kjnsdjkfndsf kjndkjnskjf knkfnsdfks kjnsdfkndskjf knfkjdnfkd kjnfkjdnfkd kjndfkjndsfkjs kjnskjfnsdjf kjnskjfndskjf kjnfkjdsnfkj kjdnfkjdnfkdsjf knfkjdsnfkjd </p>
                        </div>
                      </div>
                  <!--end bootstrap container  -->
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