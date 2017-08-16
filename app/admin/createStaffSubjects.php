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
            
                <h5 class="top-header">Assign Subject</h5>
              <div class="row">
              
              <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="staff">Select Staff</label>
                <select class="custom-select form-control" id="staff">
                <?php 
                    $client->loadStaff($clientid);
                  ?>
                </select> 
              </div>

              <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="class-admitted">Class</label>
                <select class="custom-select form-control" id="class-admitted">
                <?php 
                    $client->loadClass($clientid);
                  ?>
                </select> 
              </div>

              <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="arm">Class Arm</label>
                <select class="custom-select form-control" id="arm">
                </select> 
              </div>
    
            <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="subject">Subject</label>
                <select class="custom-select form-control" id="subject">
                <?php
                  $client->allSubjects($clientid);
                    ?>
                </select> 
              </div>
  
              </div>
               <hr class="mb-2">
              <button type="submit" class="btn btn-primary btn-md" id="add-subject">Assign Subject</button>
            
          
      