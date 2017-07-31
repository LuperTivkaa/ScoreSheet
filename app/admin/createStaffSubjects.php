<?php 
include 'inc/regSession.php';
include 'inc/autoload.php';
$clientObj = new student();
$clientid = $_SESSION['user_info'][4];
//echo $clientObj->loadStaff($clientid);
?>
            
                <h4 class="right-menu-header">Assign Subject</h4>
              <div class="row">
              
              <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="staff">Select Staff</label>
                <select class="custom-select form-control" id="staff">
                <?php 
                    $clientObj->loadStaff($clientid);
                  ?>
                </select> 
              </div>

              <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="class-admitted">Class</label>
                <select class="custom-select form-control" id="class-admitted">
                <?php 
                    $clientObj->loadClass($clientid);
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
                  $clientObj->allSubjects($clientid);
                    ?>
                </select> 
              </div>
  
              </div>
               <hr class="mb-2">
              <button type="submit" class="btn btn-primary btn-lg" id="add-subject">Add Subject</button>
            
          
      