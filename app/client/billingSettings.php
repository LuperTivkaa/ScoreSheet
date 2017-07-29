<?php 
include 'inc/regSession.php';
//load classes
include 'inc/autoload.php';
include 'inc/topHeader.php';
$clientid = $_SESSION['sess_info'][0];
?>
<title>ScoreSheet | Billing Settings</title>
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

<h4 class="right-menu-header">Billing Settings</h4>

<span class="info">The billing functionality is a component that help our our clients figure out with ease how much they are to pay on usage of the smartyEXPRESS educational management app. The default billing is monthly and may be expanded in the future. The aggregate cost is the total number of active enrollment in your school multiplied by the monthly unit cost per enrollement</span>
<h4 class="right-menu-header">Billing Cycle:</h4>
<h3>Monthly</h3>
  <!-- div to display message -->
    <div id="output" class="output">
    </div>
    <!-- end of div to display message -->        
	
</div>
<!--    end of div for main content-->

<!-- right menu side bar -->
<?php 
include 'inc/rightMenu.php';
?>
<!-- end of right menu side bar -->

</div>
</div>
<!-- Modal begins here -->



  <!-- include footer -->
<?php include 'inc/footer.php'; ?>