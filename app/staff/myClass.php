<?php 
include 'inc/regSession.php';
//load classes
include 'inc/autoload.php';
include 'inc/topHeader.php';
$clientObj = new client();
?>
<title>ScoreSheet|My Class...</title>
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
    <a class="nav-link total-class-enrollment" href="classTotalEnrollment.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>
Enrollemnt</a>
  </li>

  <li class="nav-item tabs">
    <a class="nav-link previous-class" href="previousClass.php"><i class="fa fa-bolt fa-fw" aria-hidden="true"></i>
Previous Class </a>
  </li>
  <li class="nav-item tabs">
    <a class="nav-link add-enroll" href="addEnrollment.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>
New Enrollment</a>
  </li>
  <li class="nav-item tabs">
    <a class="nav-link search-student" href="searchStudent.php"><i class="fa fa-search fa-fw" aria-hidden="true"></i>
Search Student</a>
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