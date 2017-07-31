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

              <div class="form-group col-md-4">
                 <label for="student">Select Class</label>
                <select class="custom-select  form-control" id="class-admitted">
                <?php 
                $newStaff->loadClass($clientid);
                ?>
                </select>
              </div>

              <div class="form-group col-md-4">
                
                 <label for="arm">Class Arm</label>
                <select class="custom-select  form-control" id="arm">
               
                </select>
              </div>

              <div class="form-group col-md-4">
                
                 <label for="arm">Session</label>
                <select class="custom-select form-control" id="arm">
                <?php
                   $newStaff->loadSession($clientid);
                 ?>
                </select>
              </div>

              <div class="form-group col-md-4">
                 <label for="arm">Term</label>
                <select class="custom-select form-control" id="arm">
                <?php
               $newStaff->loadTerm($clientid);
               ?>
                </select>
              </div>

               <div class="form-group col-md-4">
                 <label for="arm">Subject</label>
                <select class="custom-select form-control" id="arm">
                <?php
               $newStaff->loadTerm($clientid);
               ?>
                </select>
              </div>

              <div class="form-group col-md-6">
                 <label for="tag">Search Tag</label>
                <input type="text" class="form-control" id="tag" name="tag" placeholder="Reg Number"> 
              </div>

              </div>
               <hr class="mb-2">
              <button class="btn btn-primary btn-md" id="add-session">Search</button>
            </div>