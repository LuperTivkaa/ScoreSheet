            <?php 
include 'inc/regSession.php';
include 'inc/autoload.php';
$newStudent = new student();
$clientid = $_SESSION['user_info'][0];
?>

<!-- Enter form to create new student here -->
<div class="row mb-3">
<!--<div class="col-md-3"></div>-->
    <div class="col-md-12"><h6 class="right-menu-header text-xs-center mt-3">Add New Enrollemnt</h6></div>
<!--<div class="col-md-3"></div>-->

</div>
  
        
        <!-- ENROLL NEW STUDENT IN A CLASS -->
    <div class="row">

    <div class="form-group col-md-4">
                 <label for="tag">Admission Number</label>
                <input type="text" class="form-control" id="tag" name="tag" placeholder="Admission Number"> 
              </div>

            <div class="form-group col-md-4">
                 <label for="student-class">Choose Class</label>
                <select class="custom-select form-control" id="student-class">
                <?php 
                    
                  ?>
                </select>
              </div>

              <div class="form-group col-md-4">
                
                 <label for="add-no">Class Arm</label>
                <select class="custom-select form-control" id="">
                <?php 
                   
                  ?>
                </select>
              </div>
              <div class="form-group col-md-4">
                
                 <label for="session">Session</label>
                <select class="custom-select form-control" id="">
                <?php 
                   
                  ?>
                </select>
              </div>
              
              </div>
              <button class="submit btn btn-primary" id="assign-admission-no">Enroll Student</button>