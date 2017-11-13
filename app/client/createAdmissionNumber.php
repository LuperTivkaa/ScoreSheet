            <?php 
session_start();
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
$myroleid = $_SESSION['user_info'][2];
$staff->clientUser($myroleid,$clientid);
?>

<!-- Enter form to create new student here -->
<div class="row mb-3">
<!--<div class="col-md-3"></div>-->
    <div class="col-md-12"><h6 class="top-header text-xs-center mt-3">Add New Admission Number</h6></div>
<!--<div class="col-md-3"></div>-->
</div>

        
        <!-- ASSIGN NEW ADMISSION NUMBER -->
        <small>Click <i class="fa fa-refresh fa-fw loader" aria-hidden="true"></i> to load new student and their unassigned admission numbers.</small>
    <div class="row">

            <div class="form-group col-md-6">
                 <label for="student">Select Student</label>
                <select class="custom-select form-control" id="student">
            
                </select>
              </div>

              <div class="form-group col-md-6">
                
                 <label for="add-no">Admission Number</label>
                <select class="custom-select form-control" id="add-no" disabled>
          
                </select>
              </div>
              </div>
              <button class="submit btn btn-primary" id="assign-admission-no">Assign Admission Number</button>
              