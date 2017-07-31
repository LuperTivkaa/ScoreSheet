<?php 
include 'inc/regSession.php';
//load classes
include 'inc/autoload.php';
include 'inc/topHeader.php';
$newClient = new client();
$clientid = $_SESSION['user_info'][4];
?>
<title>ScoreSheet | Home </title>
<?php include'inc/userProfileHeader.php'; ?>


<div  class="container mt-3">
<?php
include 'inc/institutionProfile.php';
?>

<div class="row">

<!-- include side menu -->
<?php include'inc/sidemenu.php';?>
<!--end of  side menu include-->
    
<!--    div for main content-->
<div class="col-md-6">
  <!-- overview row -->
<div class="row mb-2">

  <div class="col-md-3">
            <h6 class="right-menu-header"><i class="fa fa-area-chart" aria-hidden="true"></i>
 Income</h6> <span class="badge badge-pill badge-danger">Today: 20,000</span>
          
        
  </div>

  <div class="col-md-3">
    
        <h6 class="right-menu-header"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Students</h6>
          <span class="badge badge-pill badge-danger">397</span>    
  </div>

  <div class="col-md-3">
        <h6 class="right-menu-header"><i class="fa fa-tasks" aria-hidden="true"></i> Task</h6>
        <span class="badge badge-pill badge-danger">6</span>

  </div>

  <div class="col-md-3">
        <h6 class="right-menu-header"><i class="fa fa-birthday-cake" aria-hidden="true"></i>
Birthdays</h6>
<span class="badge badge-pill badge-danger">Hurray 16</span>

  </div>

</div>

<!-- end of overview -->
<hr>
<!-- div for message -->
<div id="new-content">

</div>

</div>
<!--    end of div for main content-->
<!-- div to display message -->
    
<!-- right menu side bar -->
<?php 
include 'inc/rightMenu.php';
?>
<!-- end of right menu side bar -->

</div>
</div>

   <!-- include footer -->
<?php include 'inc/footer.php'; ?>