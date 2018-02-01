<?php 
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
use ScoreSheet\signUp;
//use \PDO;
$dbConnection = new dbConnection();
$student = new student($dbConnection);
$client = new client($dbConnection);
$staff = new staff($dbConnection);
$signup = new signUp($dbConnection);
$clientid = $_SESSION['user_info'][4];
$staffid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->staffUser($myroleid,$clientid);

$output = $signup->staffUserName($staffid,$clientid);
foreach($output as $row => $key)
    {
        $username = $key['Username'];
       
    }
?>

<div class="row mb-3">
<!--<div class="col-md-3"></div>-->
    <div class="col-md-12"><h5 class="top-header text-xs-center"> Change Password Settings </h5></div>
<!--<div class="col-md-3"></div>-->
    </div>      
<div class="row">

            <div class="form-group col-md-12">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $username;?>"  placeholder="Enter Username"> 
            </div>
            
            <div class="form-group col-md-12">
                <label for="new-pass">Password:</label>
                <input type="text" class="form-control" id="new-pass" name="new-pass" placeholder="Password"> 
            </div>
            
            <div class="form-group col-md-12">
                <label for="confirm-new-pass">Confirm Password:</label>
                <input type="text" class="form-control" id="confirm-new-pass" name="confirm-new-pass" placeholder="Confirm Password"> 
            </div>

            <div class="col-md-5"> 
            <button class="submit btn btn-primary mb-3"  id="reset-pass">Change Password</button>
            </div>
            <div class="col-md-7"> 
            <p id="match-pass"></p>
            </div>        
</div>
        







