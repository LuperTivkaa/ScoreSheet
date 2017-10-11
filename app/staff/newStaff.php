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
use ScoreSheet\staff;
//use \PDO;
$dbConnection = new dbConnection();
$student = new student($dbConnection);
$client = new client($dbConnection);
$staff = new staff($dbConnection);
$clientid = $_SESSION['user_info'][4];
?>

<div class="row mb-3">
<!--<div class="col-md-3"></div>-->
    <div class="col-md-12"><h5 class="top-header text-xs-center"> Staff Profile </h5></div>
<!--<div class="col-md-3"></div>-->
    </div>
  
  <h6 class="top-header"> Step 1: Personal Information </h6>
        
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
                 <label for="religion">Religion</label>
                <select class="custom-select form-control" id="religion" name="religion">
                      <option>Christianity</option>
                      <option>Muslim</option>
                      <option>Other</option>                          
                    </select> 
              </div>
            
             <div class="form-group col-md-4">
                 <label for="nation">Nationality:</label>
                <select class="custom-select form-control" id="nation">
                <?php
                  $client->loadNationality();
                    ?>
                </select> 
              </div>

              <div class="form-group col-md-4">
                 <label for="state">State:</label>
                <select class="custom-select form-control" id="state">                         
                    </select> 
              </div>

              <div class="form-group col-md-4">
                 <label for="lg">Lga:</label>
                <select class="custom-select form-control" id="lg">                         
                    </select> 
              </div>

            <div class="form-group col-md-3">
                 <label for="city">City:</label>
                <select class="custom-select form-control" id="city">
                </select> 
              </div>

              <div class="form-group col-md-5">
                 <label for="contactAdd">Contact Address:</label>
                <textarea class="custom-textarea form-control" id="contactAdd" name="permaDD" rows="1"></textarea> 
              </div>
              
            <div class="form-group col-md-5">
                 <label for="permAdd">Permanent Home Address:</label>
                <textarea class="custom-textarea form-control" id="permAdd" name="permAdd" rows="1"></textarea> 
              </div>

              <div class="form-group col-md-4">
                 <label for="mail">Email:</label>
                <input type="email" class="form-control" id="mail" name="mail" placeholder="Email optional"> 
              </div>

             <div class="form-group col-md-3">
                <label for="mobile">Mobile:</label>
                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile"> 
              </div>
            
              </div>
                           

  <h6 class="top-header">Step 2: Bio Data Information</h6>
        
    <div class="row">
            
             <div class="form-group col-md-4">
                 <label for="sex">Gender:</label>
                <select class="custom-select form-control" id="sex" name="sex">
                    <option>Male</option>
                      <option>Female</option>
                </select> 
              </div>
            <div class="form-group col-md-4">
                 <label for="datepicker">Date of Birth:</label>
                <input type="text" class="form-control" id="datepicker"> 
              </div>

              <div class="form-group col-md-4">
                 <label for="bloodgroup">Blood Group</label>
                <select class="custom-select form-control" id="blood-group" name="blood-group">
                      <option>A+</option>
                      <option>A-</option>
                      <option>O+</option>
                      <option>O-</option>                          
                    </select> 
              </div>
            <button class="submit btn btn-primary mb-3"  id="new-staff-btn">Create New Staff</button>
              </div>                           

  
              <!-- <button class="submit btn btn-primary mb-3"  id="new-student-btn">Create New Student</button> -->
        







