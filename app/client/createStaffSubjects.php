<?php 
include 'inc/regSession.php';
include 'inc/autoload.php';
$clientObj = new client();
$clientid = $_SESSION['sess_info'][0];
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
                 <label for="class">Class</label>
                <select class="custom-select form-control" id="class">
                <?php 
                    $clientObj->loadClass($clientid);
                  ?>
                </select> 
              </div>
    
            <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="subject">Subject</label>
                <select class="custom-select form-control" id="subject">
                
                </select> 
              </div>
  
              </div>
               <hr class="mb-2">
              <button type="submit" class="btn btn-primary btn-lg" id="add-subject">Add Subject</button>
            
          
      