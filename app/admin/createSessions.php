<?php 
include 'inc/regSession.php';
include 'inc/autoload.php';
//$clientObj = new student();
//$clientid = $_SESSION['user_info'][4];
//echo $clientObj->loadStaff($clientid);
?>

              <!-- create fee items -->
              <div id="fee-item-container">

              <h4 class="right-menu-header ">Create Academic Session(s)</h4>
              <div class="row">

              <div class="form-group col-md-6">
                 <label for="session">Session</label>
                <input type="text" class="form-control" id="session" name="session" placeholder="session"> 
              </div>

              </div>
               <hr class="mb-2">
              <button class="btn btn-primary btn-lg" id="add-session">Add Session</button>
            </div>