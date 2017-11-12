<?php 
//session_start();
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
$staff->adminUser($userid,$clientid);
?>

<!--Content container  -->
<div class="container pt-2 mt-3">

<!--Another row begins  -->
  <div class="row">
    <div class="col-md-6">
      <h4 class="top-header">Student - Guardian Information</h4>
    </div>

    <div class="col-md-6">

    </div>
  </div>
  <!--another row ends  -->

<!--Another row beigns  -->
 <div class="row">
    <div class="col-md-6">
              <div class="form-group col-md-12">
                 <label for="student">Select Student</label>
                 <select class="custom-select form-control" id="student">
                 </select> 
                 <small>Click <i class="fa fa-refresh fa-fw load-new-student" aria-hidden="true"></i> to load new student whose parent details have not been added yet!.</small>
              </div>
    </div>

    <div class="col-md-3">

    </div>

    <div class="col-md-3">

    </div>

  </div>
  <!--another row ends  -->

  
      <!--containing row  -->
      <div class="row mb-3">


            <div class="col-md-4">

                    <div class="row">
                      
                      <div class="form-group col-md-12">
                        <label for="surname">Surname:</label>
                        <input type="text" class="form-control" id="surname" name="surname" placeholder="surname"> 
                      </div>
                    
                      <div class="form-group col-md-12">
                        <label for="sex">Gender:</label>
                        <select class="custom-select form-control" id="sex" name="sex">
                              <option>Male</option>
                              <option>Female</option>
                        </select> 
                      </div>

                      
                        <div class="form-group col-md-12">
                          <label for="occupation">Occupation:</label>
                          <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Occupation"> 
                        </div>

                        <div class="form-group col-md-12 mb-0">
                          <label class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="emergency-contact" value="true">
                          <span class="custom-control-indicator"></span>
                          <span class="custom-control-description">Emergency Contact?</span>
                          </label>
                        </div>

                         <button class="btn btn-primary mb-3" id="add-guardian-info"> Add Parent</button>

                    </div>
                  
            </div>

            <!--middle div  -->
            <div class="col-md-4">

                <div class="row">

                      <div class="form-group col-md-12">
                        <label for="firstname">First Name:</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname"> 
                      </div>
              
                      <div class="form-group col-md-12">
                        <label for="relationship">Relationship:</label>
                        <select class="custom-select form-control" id="relationship">
                          <?php
                          $student->loadRelationship();
                          ?>
                        </select> 
                      </div>
                
                        <div class="form-group col-md-12">
                          <label for="mobile">Mobile:</label>
                          <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile"> 
                        </div>

                      

                </div>

                  
            </div>
            <!--end middle div  -->


            <!--Third div  -->
            <div class="col-md-4">

              <div class="row">

                <div class="form-group col-md-12">
                  <label for="lastname">Last Name:</label>
                  <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname"> 
                </div>

                <div class="form-group col-md-12">
                    <label for="cont_add">Residential/Contact Address:</label>
                    <input type="text" class="form-control" id="cont-add" name="cont-add" placeholder="Contact Address">  
                </div>

                <div class="form-group col-md-12">
                    <label for="parent-mail">Email:</label>
                    <input type="email" class="form-control" id="parent-mail" name="parent-mail" placeholder="Email"> 
                 </div>

              </div> 

            </div>
            <!--End third div  -->

      <div>
        <!--end containing row  -->

</div>
<!--End content container  -->

































































               
              