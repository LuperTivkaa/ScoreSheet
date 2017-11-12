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

<!--Content container  -->
<div class="container pt-2 mt-3">

  <div class="row">
    <div class="col-md-6">
      <h4 class="top-header">Upload Student Passport</h4>
    </div>

    <div class="col-md-6">

    </div>
  </div>
      <!--containing row  -->
      <div class="row mb-3">


            <div class="col-md-4">

                <div class="row">
                    <div class="col-md-12">
                    <form action=""  method="post" enctype="multipart/form-data">
                       <span>Please click on the camera icon to upload your photo</span>
                        

                                    <div class="form-group image-upload">

                                    <label for="logo-file">

                                    <i class="fa fa fa-camera fa-5x"></i>

                                    </label>
                            
                                    <input type="file" name="image-file" class="form-control" id="image-file">

                                    </div>
                                    <div id="success-msg">
                                    <p id="msg"></p>
                                    </div>
                    </form>
                     </div>

                </div>
                  
            </div>

            <!--middle div  -->
            <div class="col-md-4">

                <div class="row">


                </div>

                  
            </div>
            <!--end middle div  -->


            <!--Third div  -->
            <div class="col-md-4">

              <div class="row">


              </div> 

            </div>
            <!--End third div  -->



      <div>
        <!--end containing row  -->

</div>
<!--End content container  -->

