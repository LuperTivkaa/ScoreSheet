<?php 
include 'inc/regSession.php';
//load classes
include 'inc/autoload.php';
include 'inc/topHeader.php';
$clientObj = new client();
?>
<title>ScoreSheet |My Staff</title>
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
    <a class="nav-link new-emplyee" href="newStaff.php"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i>
New Staff</a>
  </li>

  <li class="nav-item tabs">
    <a class="nav-link new-subject" href="createStaffSubjects.php"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i>
Add Subject</a>
  </li>
  <li class="nav-item tabs">
    <a class="nav-link my-staff" href="male.php"><i class="fa fa-male fa-fw" aria-hidden="true"></i>
Staff <span class="badge badge-pill badge-danger">20</span></a>
  </li>
  <li class="nav-item tabs">
    <a class="nav-link my-staff" href="female.php"><i class="fa fa-female fa-fw" aria-hidden="true"></i>
Staff <span class="badge badge-pill badge-danger">20</span></a>
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