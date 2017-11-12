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

              <!-- create fee items -->
              <div id="fee-item-container">

              <h5 class="top-header ">Create Fee Items</h5>
              <div class="row">

              <div class="form-group col-md-6">
                 <label for="item">Item</label>
                <input type="text" class="form-control" id="item" name="item" placeholder="Fee Item"> 
              </div>

              <div class="form-group col-md-6">
                 <label for="amount">Amount</label>
                <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount"> 
              </div>

              <div class="form-group col-md-6">
                 <label for="amount-words">Amount in Words</label>
                <input type="text" class="form-control" id="amount-words" name="amount-words" placeholder="Amount in Words"> 
              </div>
              
              <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="term">Term</label>
                <select class="custom-select form-control" id="term">
                <?php 
                $client->loadTerm($clientid); 
              
                  ?>
                </select> 
              </div>
    
            <div class="form-group col-md-12 margin-bottom-sm">
                 <label for="session">Session</label>
                <select class="custom-select form-control" id="session">
                 <?php 
                $client->loadSession($clientid);
                  ?>
                </select> 
              </div>
  
              </div>
               <hr class="mb-2">
              <button class="btn btn-primary btn-md" id="term-fee-items">Add Fee Item</button>
            </div>