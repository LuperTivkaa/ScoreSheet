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
$staff->staffUser($myroleid,$clientid);
?>

<!--Content container  -->
<div class="container pt-2 mt-3">

  <div class="row">
    <div class="col-md-6">
      <h4 class="top-header">Upload Staff Photo</h4>
    </div>

    <div class="col-md-6">

    </div>
  </div>
      <!--containing row  -->
      <div class="row mb-3">


            <div class="col-md-4">

                <div class="row">
                    <div class="col-md-12">
                    <form id="form" action="staffPictureProcess.php"  method="post" enctype="multipart/form-data">
                       <span>Please click on the camera icon to upload your photo</span>
                        

                                    <div class="form-group image-upload">

                                    <label for="staff-file">

                                    <i class="fa fa fa-camera fa-5x"></i>

                                    </label>
                            
                                    <input type="file" name="staff-file" class="form-control" id="staff-file">

                                    </div>
                                    <div id="success-msg">
                                       <p id="msg"></p>
                                    </div>
                                    <div id="preview-img">
                                    
                                    </div>
                                    <div id="err">
                                    
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

