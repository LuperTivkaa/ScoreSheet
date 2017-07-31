<?php 
include 'inc/regSession.php';
//load classes
include 'inc/autoload.php';
include 'inc/topHeader.php';
$clientObj = new client();
?>
<title>ScoreSheet|Result Centre...</title>
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
  
    <!-- end of div to display message -->
<!--  end of output class-->
    <ul class="nav nav-tabs">
  <li class="nav-item tabs">
    <a class="nav-link add-ca" href="processExams.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>
Process Scores</a>
  </li>

  <li class="nav-item tabs">
    <a class="nav-link search-ca" href="viewScores.php"><i class="fa fa-search fa-fw" aria-hidden="true"></i>
View Scores </a>
  </li>
  <li class="nav-item tabs">
    <a class="nav-link add-exam" href="createPsychomotor.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>
Cognitive</a>
  </li>
  <li class="nav-item tabs">
    <a class="nav-link search-exam" href="searchExam.php"><i class="fa fa-search fa-fw" aria-hidden="true"></i>
Search Exam</a>
  </li>
  <!-- <li class="nav-item tabs">
    <a class="nav-link" href="settings.php"><i class="fa fa-cog fa-fw" aria-hidden="true"></i>
Manage Staff</a>
  </li> -->
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