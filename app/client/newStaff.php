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
            <h5 class="top-header">Create New Staff</h5>
            
              <div class="row newStaff">
              
              
              <div class="form-group col-md-12 margin-bottom-sm">
                 <label for="username">User Name</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Choose Username"> 
              </div>

              <div class="form-group col-md-12 margin-bottom-sm">
                 <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email"> 
              </div>

              <div class="form-group col-md-12 margin-bottom-sm">
                 <label for="my-pass">Password</label>
                <input type="password" class="form-control" id="my-pass" name="my-pass" placeholder="Enter Password"> 
              </div>
    
            <div class="form-group col-md-12 margin-bottom-sm">
                 <label for="role">Role</label>
                <select class="custom-select form-control" id="role">
                <?php 
                    $client->loadRoles();
                  ?>
                </select> 
              </div>

              </div>
              <button class="btn btn-primary btn-md mb-3" id="staff-account">Create Staff</button>
            
          
      