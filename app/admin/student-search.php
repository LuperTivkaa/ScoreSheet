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
            <h5 class="top-header">Search Student</h5>
            <div class="container">
            

             <div class="row">

                
                  <div class="form-group col-md-12">
                  <label for="subject-list">Search Student</label>
                  <input type="text" class="form-control" id="searchitem" name="searchitem" placeholder="Search by surname or school id"> 
                  <button class="submit btn btn-primary mt-3" id="search-btn">Search Student</button>
                  </div>
                  
                

              </div>
             </div>
            
          
      