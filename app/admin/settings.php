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
    <a class="nav-link new-fee" href="feeItems.php"><i class="fa fa-plus-square-o fa-fw" aria-hidden="true"></i>
  Fee Items</a>
  </li>

  <li class="nav-item tabs">
    <a class="nav-link added-fee-item" href="myFeeItems.php"><i class="fa fa-cogs fa-fw" aria-hidden="true"></i>
Fee</a>
  </li>
  
  <li class="nav-item tabs">
    <a class="nav-link new-numbers" href="setAdmissionNumber.php"><i class="fa fa-cog fa-fw" aria-hidden="true"></i>
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