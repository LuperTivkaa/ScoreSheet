<?php 
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
//use \PDO;
$dbConnection = new dbConnection();
$client = new client($dbConnection);
$clientid = $_SESSION['user_info'][4];

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
            
          
      