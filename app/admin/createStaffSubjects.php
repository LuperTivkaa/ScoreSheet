<?php 
session_start();
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
$roleid = $_SESSION['user_info'][2];
$staff->adminUser($roleid,$clientid);

//echo $clientObj->loadStaff($clientid);
?>
            
                <h5 class="top-header">Assign Subject</h5>
              <div class="row">
              
              <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="staff">Select Staff</label>
                <select class="custom-select form-control" id="staff">
                <?php 
                    $client->loadApprovedStaff($clientid);
                  ?>
                </select> 
              </div>

              <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="class">Class</label>
                <select class="custom-select form-control" id="class">
                <?php 
                    $client->loadClass($clientid);
                  ?>
                </select> 
              </div>

              <!-- <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="arm">Class Arm</label>
                <select class="custom-select form-control" id="arm">
                </select> 
              </div> -->
    
            <div class="form-group col-md-12 margin-bottom-sm">
                 <label for="subject">Subject</label>
                <select class="custom-select form-control" id="subject">
                </select> 
              </div>
  
              </div>
               <hr class="mb-2">
              <button type="submit" class="btn btn-primary btn-md" id="add-subject">Assign Subject</button>
            
          
      