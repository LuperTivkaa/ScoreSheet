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
    <title>ScoreSheet| Exam Task Panel </title>
    <?php include '../inc/scoresheet-header.php';
    $clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->clientUser($myroleid,$clientid); 
    ?>
              <!-- Intro content div  -->

                  <div class="intro-content">
                  <!--conatiner  -->
                        <div class="container">

                            <div  class="row">

                                <div class="col-md-3">
                                </h6>

                                </div>

                                <div class="col-md-6 mt-0">
                                <?php
                                $client->schoolProfilePreview($clientid) 
                                ?>

                                </div>

                                <div class="col-md-3">

                                </div>

                            </div>

                        </div>
                        <!--end container  -->
                  </div>
                  <!-- End Intro content div  -->