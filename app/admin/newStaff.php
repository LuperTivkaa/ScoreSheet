              <?php 
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
//use \PDO;
$dbConnection = new dbConnection();
$client = new client($dbConnection);
?>
            <h5 class="top-header">Create New Staff</h5>
            
              <div class="row newStaff">
              
              
              <div class="form-group col-md-12 margin-bottom-sm">
                 <label for="username">User Name</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Choose Username"> 
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
               <hr class="mb-2">
              <button class="btn btn-primary btn-lg" id="staff-account">Create Staff</button>
            
          
      