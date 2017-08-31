            <?php 
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
//use \PDO;
$dbConnection = new dbConnection();
$student = new student($dbConnection);
$client = new client($dbConnection);
$clientid = $_SESSION['user_info'][4];
//$newStaff = new student();
$userid = $_SESSION['user_info'][0];
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
              <div class="col-6">
                  <button class="submit btn btn-primary" id="assign-admission-no">Assign Admission Number</button>
              </div>
              
              </div>
              