            <?php 
include 'inc/regSession.php';
include 'inc/autoload.php';
$newStudent = new student();
$clientid = $_SESSION['user_info'][0];
?>

<!-- Enter form to create new student here -->
<div class="row mb-3">
<!--<div class="col-md-3"></div>-->
    <div class="col-md-12"><h6 class="right-menu-header text-xs-center mt-3">Total Students Enrolled</h6></div>
<!--<div class="col-md-3"></div>-->

</div>
  
        
        <!-- ENROLL NEW STUDENT IN A CLASS -->
    <div class="row list-of-enrolled-class">

        
              
    </div>
              