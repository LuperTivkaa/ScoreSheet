<?php 
include 'inc/regSession.php';
include 'inc/autoload.php';
$newStaff = new student();
$clientid = $_SESSION['user_info'][4];
//echo $clientObj->loadStaff($clientid);
?>

              <!-- create fee items -->
              <div id="fee-item-container">
              <h4 class="right-menu-header mt-3">Search Continous Assessment</h4>
              
              <div class="row">

              <div class="form-group col-md-6">
                 <label for="tag">Search Tag</label>
                <input type="text" class="form-control" id="tag" name="tag" placeholder="Reg Number, surname"> 
              </div>

              </div>
               <hr class="mb-2">
              <button class="btn btn-primary btn-md" id="search-ca">Search</button>
            </div>