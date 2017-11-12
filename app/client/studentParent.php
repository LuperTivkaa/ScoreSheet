            <?php 
//session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
//use \PDO;
$dbConnection = new dbConnection();
$student = new student($dbConnection);
$client = new client($dbConnection);
$staff = new staff($dbConnection);
//$jobmanager = new manager($dbConnection);
$clientid = $_SESSION['user_info'][4];
//$newStaff = new student();
$userid = $_SESSION['user_info'][0];
$staff->clientUser($userid,$clientid);
?>
<!-- Enter form to create new student here -->
<div class="row mb-3">
<!--<div class="col-md-3"></div>-->
    <div class="col-md-12"><h6 class="top-header text-xs-center">Student - Parent Information</h6></div>
<!--<div class="col-md-3"></div>-->
    </div>

    <!--progress bar div    -->
<div class="mb-3">
    <div class="form-group col-md-12">
                 <label for="student">Select Student</label>
                <select class="custom-select form-control" id="student">
                </select> 
              </div>
              <small>Click <i class="fa fa-refresh fa-fw load-new-student" aria-hidden="true"></i> to load new student whose parent details have not been added yet!.</small>
              <hr>
  </div>
      <h6 class="top-header text-xs-center">Parent Information</h6>  
    <div class="row">
            
             <div class="form-group col-md-4">
                 <label for="surname">Surname:</label>
                <input type="text" class="form-control" id="surname" name="surname" placeholder="surname"> 
              </div>
            
            <div class="form-group col-md-4">
                 <label for="firstname">First Name:</label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname"> 
              </div>

              <div class="form-group col-md-4">
                 <label for="lastname">Last Name:</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname"> 
              </div>

              <div class="form-group col-md-4">
                 <label for="occupation">Occupation:</label>
                <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Occupation"> 
              </div>

              <div class="form-group col-md-4">
                 <label for="sex">Gender:</label>
                <select class="custom-select form-control" id="sex" name="sex">
                      <option>Male</option>
                      <option>Female</option>
                </select> 
              </div>
            
             <div class="form-group col-md-4">
                 <label for="relationship">Relationship:</label>
                <select class="custom-select form-control" id="relationship">
                <?php
                  $student->loadRelationship();
                    ?>
                </select> 
              </div>

              
              <div class="form-group col-md-5">
                 <label for="cont_add">Contact Address:</label>
                <textarea class="custom-textarea form-control" id="cont_add" name="cont_add" rows="1"></textarea> 
              </div>
              

              <div class="form-group col-md-4">
                 <label for="parent-mail">Email:</label>
                <input type="email" class="form-control" id="parent-mail" name="parent-mail" placeholder="Email"> 
              </div>

             <div class="form-group col-md-3">
                 <label for="mobile">Mobile:</label>
                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile"> 
              </div>
              </div>
               <div class="form-group mb-0">
                  <label class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="emergency-contact" value="true">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">Emergency Contact?</span>
                  </label>
                </div>
              <button class="submit btn btn-primary mb-3" id="add-parent-info">Add Parent</button>