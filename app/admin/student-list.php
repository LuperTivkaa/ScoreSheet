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
            
          
      