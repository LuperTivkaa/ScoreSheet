            <?php 
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
//use \PDO;
$dbConnection = new dbConnection();
$client = new client($dbConnection);
$student = new student($dbConnection);
$clientid = $_SESSION['user_info'][4];
?>

<!-- Enter form to create new student here -->
<div class="row mb-3">
<!--<div class="col-md-3"></div>-->
    <div class="col-md-12"><h6 class="top-header text-xs-center mt-3">Add New Admission Number</h6></div>
<!--<div class="col-md-3"></div>-->
</div>

        
        <!-- ASSIGN NEW ADMISSION NUMBER -->
    <div class="row">

            <div class="form-group col-md-6">
                 <label for="student">Select Student</label>
                <select class="custom-select form-control" id="student">
                <?php 
                    $student->getStudentAssign($clientid);
                  ?>
                </select>
              </div>

              <div class="form-group col-md-6">
                
                 <label for="add-no">Admission Number</label>
                <select class="custom-select form-control" id="add-no" disabled>
                <?php 
                    $student->loadUnassignedNumber($clientid);
                  ?>
                </select>
              </div>
              
              </div>
              <button class="submit btn btn-primary" id="assign-admission-no">Assign Admission Number</button>
              