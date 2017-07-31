<?php 
include 'inc/regSession.php';
//load classes
include 'inc/autoload.php';
include 'inc/topHeader.php';
$clientObj = new client();
?>
<title>ScoreSheet |Settings</title>
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
  <h5 class="right-menu-header text-xs-center">Settings</h5>
    <!-- end of div to display message -->
<!--  end of output class-->
    <ul class="nav nav-tabs">
  <li class="nav-item tabs">
    <a class="nav-link new-session" href="createSessions.php"><i class="fa fa-plus-circle fa-fw" aria-hidden="true"></i>
Session</a>
  </li>

  <li class="nav-item tabs">
    <a class="nav-link new-fee" href="createSubjects.php">
New Subject</a>
  </li>

  <li class="nav-item tabs">
    <a class="nav-link new-term" href="academicTerm.php">
Term</a>
  </li>

  <li class="nav-item tabs">
    <a class="nav-link my-session" href="mySessions.php">
Sessions</a>
  </li>
  <li class="nav-item tabs">
    <a class="nav-link added-fee-item" href="createClass.php">
New Class</a>
  </li>
  <li class="nav-item tabs">
    <a class="nav-link new-numbers" href="setAdmissionNumber.php">
Generate Numbers</a>
  </li>
</ul>

<!-- div to display message -->
    <div id="my-info">
    
    </div>

    <div id="new-content">
      
    </div>

</div>
<!--    end of div for main content-->

<!-- right menu side bar -->
<?php 
include 'inc/rightMenu.php';
?>
<!-- end of right menu side bar -->

</div>
</div>
  <!-- include footer -->
<?php include 'inc/footer.php'; ?>