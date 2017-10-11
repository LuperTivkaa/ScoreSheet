<script>
   //$("#new-content").on('click', '#datepicker', function(e){
           //e.preventDefault();
          $(function() {
    $( "#datepicker" ).datepicker();
  });
    
</script>
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
?>

<div class="row mb-3">
<!--<div class="col-md-3"></div>-->
    <div class="col-md-12"><h5 class="top-header text-xs-center"> Staff Educational Information </h5></div>
<!--<div class="col-md-3"></div>-->
    </div>
  
  <h6 class="top-header"> Academic Records </h6>
        
    <div class="row">
            
            <div class="form-group col-md-4">
                <label for="inst-name">Institution Name:</label>
                <input type="text" class="form-control" id="inst-name" name="inst-name" placeholder="Institution name"> 
            </div>
            
            <div class="form-group col-md-4">
                 <label for="cert-name">Certificate Obtained:</label>
                <input type="text" class="form-control" id="cert-name" name="cert-name" placeholder="Certificate Obtained"> 
            </div>

            <div class="form-group col-md-4">
                 <label for="yr-grad">Year of Graduation:</label>
                <input type="text" class="form-control" id="yr-grad" name="yr-grad" placeholder="Year of Graduation"> 
            </div>

            <button class="submit btn btn-primary mb-3"  id="new-qualification-btn">Add Details</button>
              </div>
                                                     
              <!-- <button class="submit btn btn-primary mb-3"  id="new-student-btn">Create New Student</button> -->
        







