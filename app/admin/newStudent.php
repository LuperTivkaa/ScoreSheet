<script>
   //$("#new-content").on('click', '#datepicker', function(e){
           //e.preventDefault();
          $(function() {
    $( "#datepicker" ).datepicker();
  });
    
</script>
           <?php 
//session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
use Carbon\Carbon;
//use \PDO;
$dbConnection = new dbConnection();
$client = new client($dbConnection);
$student = new student($dbConnection);
$staff = new staff($dbConnection);

$clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];
$staff->adminUser($userid,$clientid);
?>

<div class="container pt-2 mt-3">

  <!--Other row for heading  -->
  <div class="row">
    <div class="col-md-6">
      <h4 class="top-header">Student's Personal Information Data</h4>
    </div>

    <div class="col-md-6">

    </div>
  </div>
  <!--another row ends  -->

  <!--containing row  -->
  <div class="row">

      <!--first column  -->
     <div class="col-md-4">

              <div class="form-group col-md-12">
                 <label for="surname">Surname:</label>
                <input type="text" class="form-control" id="surname" name="surname" placeholder="surname"> 
              </div>

              <div class="form-group col-md-12">
                    <label for="sex">Gender:</label>
                  <select class="custom-select form-control" id="sex" name="sex">
                      <option>Male</option>
                      <option>Female</option>
                  </select> 
              </div>

              <div class="form-group col-md-12">
                <label for="state">State:</label>
                <select class="custom-select form-control" id="state">                         
                </select> 
              </div>

              <div class="form-group col-md-12">
                 <label for="religion">Religion</label>
                <select class="custom-select form-control" id="religion" name="religion">
                      <option>Christianity</option>
                      <option>Muslim</option>
                      <option>Other</option>                          
                </select> 
              </div>

            <div class="form-group col-md-12">
                <label for="mobile">Mobile:</label>
                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile"> 
            </div>

     </div>
     <!--end first ccolumn  -->


      <!--End second column  -->
     <div class="col-md-4">

              <div class="form-group col-md-12">
                 <label for="firstname">First Name:</label>
                  <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname"> 
              </div>

              <div class="form-group col-md-12">
                <label for="datepicker">Date of Birth:</label>
                <input type="text" class="form-control" id="datepicker"> 
              </div>

              <div class="form-group col-md-12">
                 <label for="lg">Lga:</label>
                <select class="custom-select form-control" id="lg">                         
                </select> 
              </div>

              <div class="form-group col-md-12">
                 <label for="address1">Residential/Contact Address:</label>
                <textarea class="custom-textarea form-control" id="address1" name="address1" rows="1"></textarea> 
              </div>

              <div class="form-group col-md-12">
                 <label for="mail">Email [Optional]:</label>
                <input type="email" class="form-control" id="mail" name="mail" placeholder="Email optional"> 
              </div>

     </div>
     <!--End second column  -->

      <!--Third column  -->
     <div class="col-md-4">

              <div class="form-group col-md-12">
                 <label for="lastname">Last Name:</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname"> 
              </div>

              <div class="form-group col-md-12">
                 <label for="nation">Nationality:</label>
                <select class="custom-select form-control" id="nation">
                <?php
                  $client->loadNationality();
                    ?>
                </select> 
              </div>

               <div class="form-group col-md-12">
                 <label for="city">Town/City:</label>
                <select class="custom-select form-control" id="city">
                </select> 
              </div>

                <div class="form-group col-md-12">
                 <label for="address2">Permanent/Home Address:</label>
                <textarea class="custom-textarea form-control" id="address2" name="address2" rows="1"></textarea> 
              </div>

              
              <div class="form-group col-md-12">
                 <label for="bloodgroup">Blood Group</label>
                <select class="custom-select form-control" id="blood-group" name="blood-group">
                      <option>A+</option>
                      <option>A-</option>
                      <option>O+</option>
                      <option>O-</option>                          
                    </select> 
              </div>
      
     </div>
     <!--end third column  -->



  </div>
  <!--end containing row  -->

  <!--Other row for heading  -->
  <div class="row">
    <div class="col-md-6">
      <h4 class="top-header">Student's Educational Information</h4>
    </div>

    <div class="col-md-6">

    </div>
  </div>
  <!--another row ends  -->


  <!--Another containig row  -->
  <div class="row">

    <div class="col-md-4">

        <div class="form-group col-md-12">
                 <label for="class-admitted">Class Admitted:</label>
                <select class="custom-select form-control" id="class-admitted" name="class-admitted">
                <?php
                  $client->loadClass($clientid);
                    ?>
                </select> 
        </div>

    </div>


    <div class="col-md-4">

      <div class="form-group col-md-12">
                 <label for="session">Session Admitted:</label>
                <select class="custom-select form-control" id="session" name="session">
                  <?php
                  $client->loadSession($clientid);
                  ?>
                </select> 
      </div>

    </div>


    <div class="col-md-4">

      <div class="form-group col-md-12">
                 <label for="adm-type">Admission Type:</label>
                <select class="custom-select form-control" id="adm-type" name="adm-type">
                <option>New Admission</option>
                <option>Transfer</option>
                </select> 
      </div>

    </div>

  </div>
  <!--End another containing row  -->

  <!--Other row for heading  -->
  <div class="row">
    <div class="col-md-3">
    <button class="submit btn btn-primary mb-3"  id="new-student-btn">Create New Student</button>

    </div>

    <div class="col-md-6">

    </div>
    <div class="col-md-3">

    </div>

  </div>
  <!--another row ends  -->

</div>
<!--end container  -->







