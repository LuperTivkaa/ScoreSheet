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
//$jobmanager = new manager($dbConnection);
$clientid = $_SESSION['user_info'][4];
//$newStaff = new student();
$userid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->clientUser($myroleid,$clientid);
?>

<!--Content container  -->
<div class="container pt-2 mt-3">

  <div class="row">
    <div class="col-md-6">
      <h4 class="top-header">New Institutional Profile</h4>
    </div>

    <div class="col-md-6">

    </div>
  </div>
  <!--another row ends  -->
  
      <!--containing row  -->
      <div class="row mb-3">


            <div class="col-md-4">

                    <div class="row">
                      
                      <div class="form-group col-md-12">
                       <label for="institution_name">Institution Name</label>
                        <input type="text" class="form-control" id="institution_name" name="institution_name" placeholder="Institution name">
                      </div>
                    
                      <div class="form-group col-md-12">
                        <label for="institution_category">Institution Category</label>
                        <select class="custom-select form-control" id="institution_category" name="institution_category">
                              <?php 
                              $client->loadInstCategory();
                              ?>
                            </select> 
                      </div>

                      <div class="form-group col-md-12">
                        <label for="webAdd">Web Address</label>
                          <input type="text" class="form-control" id="webAdd" name="webAdd" placeholder="Website Address" required /> 
                      </div>

                    </div>
                  
            </div>

            <!--middle div  -->
            <div class="col-md-4">

                <div class="row">
                      <div class="form-group col-md-12">
                        <label for="nation">Nationality</label>
                        <select class="custom-select form-control" id="nation" name="nation">
                          <?php 
                          $client->loadNationality();
                          ?>
                        </select> 
                      </div>
              
                      <div class="form-group col-md-6">
                        <label for="state">State</label>
                        <select class="custom-select form-control" id="state" name="state">
                        </select>
                      </div>
                
                        <div class="form-group col-md-6">
                          <label for="lg">Local Govt Area</label>
                          <select class="custom-select form-control" id="lg" name="lg">
                          </select> 
                        </div>

                        <div class="form-group col-md-12">
                          <label for="city">City</label>
                          <select class="custom-select form-control" id="city">
                          </select>
                        </div>

                       <div class="form-group col-md-12">
                        <label for="Email">Email</label>
                        <input type="text" class="form-control" id="Email" name="Email" placeholder="Email" required /> 
                      </div>

                    <button type="submit" class="btn btn-primary btn-md mb-3" id="sch-profile-btn">Add School Profile</button>


                </div>

                  
            </div>
            <!--end middle div  -->


            <!--Third div  -->
            <div class="col-md-4">

              <div class="row">

                <div class="form-group col-md-12">
                   <label for="streetAdd">Street Address</label>
                    <input type="text" class="form-control" id="streetAdd" name="streetAdd" placeholder="Street Address" required /> 
                </div>

                <div class="form-group col-md-12">
                  <label for="mailAdd">Mail Address</label>
                    <input type="text" class="form-control" id="mailAdd" name="mailAdd" placeholder="Mail Address Eg P.O Box" required /> 
                </div>

                 <div class="form-group col-md-12">
                  <label for="mobile">Mobile</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="mobile" required /> 
                </div>

              </div> 

            </div>
            <!--End third div  -->






      <div>
        <!--end containing row  -->

</div>
<!--End content container  -->

