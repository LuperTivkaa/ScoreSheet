<?php
session_start();
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
$clientid = $_SESSION['user_info'][4];
//$newStaff = new student();
$userid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->staffUser($myroleid,$clientid);
?>
<div class="row mb-3">
                          <div class="col-6">
                            <label for="promotedsession">Promoted Session</label>
                            <select class="custom-select  form-control" id="promotedsession">
                            <?php
                               $client->loadSession($clientid);
                            ?>
                            </select>
                            </div>
                            <div class="col-6">
                            <label for="promotedclass">Promoted Class</label>
                            <select class="custom-select  form-control" id="promotedclass">'
                            <?php
                                $client->loadClass($clientid);
                              ?>
                            </select>
                            </div>
</div>