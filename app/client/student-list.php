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
$clientid = $_SESSION['user_info'][4];
//$newStaff = new student();
$userid = $_SESSION['user_info'][0];
$staff->clientUser($userid,$clientid);

//echo $clientObj->loadStaff($clientid);
?>
            <h5 class="top-header">All Student(s) List</h5>
             <div class="container">

                <div class="row">

                <div class="col-12 list">
                <?php $client->initialStudentList($clientid);?>
                </div>
                <input type="hidden" id="row_no" value="10">

                </div>
             </div>
            
          
      