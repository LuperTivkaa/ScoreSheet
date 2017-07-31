            <?php 
include 'inc/regSession.php';
include 'inc/autoload.php';
$newStudent = new student();
$clientid = $_SESSION['user_info'][0];
?>

<!-- Enter form to create new student here -->
<div class="row mb-3">
<!--<div class="col-md-3"></div>-->
    <div class="col-md-12"><h6 class="right-menu-header text-xs-center mt-3">Sort Students Examination</h6></div>
<!--<div class="col-md-3"></div>-->
</div>

        
        <!-- FIND THE CLASS POSITION OF SUBJECT TAUGHT -->
    <div class="row">

            <div class="form-group col-md-4">
                 <label for="student">Select Student</label>
                <select class="custom-select form-control" id="student">
                <?php 
                    
                  ?>
                </select>
              </div>

              <div class="form-group col-md-4">
                
                 <label for="add-no">Admission Number</label>
                <select class="custom-select form-control" id="add-no" disabled>
                <?php 
                   
                  ?>
                </select>
              </div>
              
              </div>
              <button class="submit btn btn-primary" id="assign-admission-no">Assign Admission Number</button>