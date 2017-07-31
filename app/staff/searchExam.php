<?php 
include 'inc/regSession.php';
include 'inc/autoload.php';
//$clientObj = new student();
$clientid = $_SESSION['user_info'][0];
//echo $clientObj->loadStaff($clientid);
?>

              <!-- create fee items -->
              <div id="fee-item-container">

              <h4 class="right-menu-header ">Search Terminal Examination Scores</h4>
              <div class="row">

              <div class="form-group col-md-6">
                 <label for="exam-search-tag">Search Tag</label>
                <input type="text" class="form-control" id="exam-search-tag" name="exam-search-tag" placeholder="Name, Reg Number"> 
              </div>

              </div>
               <hr class="mb-2">
              <button class="btn btn-primary btn-md" id="search-exam">Search Examination Scores</button>
            </div>