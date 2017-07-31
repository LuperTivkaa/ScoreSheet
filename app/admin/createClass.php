<?php 
include 'inc/regSession.php';
include 'inc/autoload.php';
$clientObj = new student();
$clientid = $_SESSION['user_info'][4];
//echo $clientObj->loadStaff($clientid);
?>

              <!-- create fee items -->
              <div id="fee-item-container">

              <h4 class="right-menu-header ">Create New Class</h4>
              <div class="row">

            <div class="form-group col-md-5">
            <label for="class-name">Class Name:</label>
                <input type="text" class="form-control" id="class-name" name="class-name" placeholder="E.g JSS1 or Primary 1">
            </div>

              
              </div>
              <button class="submit btn btn-primary" id="add-new-class">Add New Class</button>

              <hr>
              <div class="row">
              <div class="col-md-12 mb-3">
              <h4 class="right-menu-header text-xs-center mt-3">Specify Class Arm</h4><small>Select class and enter appropriate description. Click <i class="fa fa-refresh fa-fw reload-class" aria-hidden="true"></i> to load Classes.</small>
              </div>
              </div>

              <div class="row">

            <div class="form-group col-md-4">
                <label for="class-list">Select Class</label>
                <select class="custom-select form-control" id="class-list">
                </select>
              </div>

              <div class="form-group col-md-4">
                
                 <label for="class-desc">Class Description</label>
                <input type="text" class="form-control" id="subject" name="class-desc" placeholder="E.g Alpha or A">
              </div>
              
              </div>
              <button class="submit btn btn-primary" id="assign-desc">Assign Class Description</button>
            </div>