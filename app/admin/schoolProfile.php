<?php 
include 'inc/regSession.php';
//load classes
include 'inc/autoload.php';
include 'inc/topHeader.php';
$newClient = new client();
$clientid = $_SESSION['user_info'][4];
?>
<title>ScoreSheet | School Profile</title>
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
  
<!-- Pop up button -->
		<P><button type="button" class="btn btn-info btn-md my-3" data-toggle="modal" data-target="#register"><i class="fa fa-plus" aria-hidden="true"></i>
New School Profile</button></P>

<!-- div for message -->
<div id="profile-info">

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

 <!-- Modal begins here -->


<div id="register" class="modal fade">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-xs-center text-white">
      <h4 class="modal-title">New Institutional Profile</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <div class="row">

              <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="institution_name">Institution Name</label>
                <input type="text" class="form-control" id="institution_name" name="institution_name" placeholder="Institution name"> 
              </div>
    
            <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="institution_category">Institution Category</label>
                <select class="custom-select form-control" id="institution_category" name="institution_category">
                <?php 
                    $newClient->loadInstCategory();
                  ?>
                </select> 
              </div>

              <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="nation">Nationality</label>
                <select class="custom-select form-control" id="nation" name="nation">
                  <?php 
                    $newClient->loadNationality();
                  ?>
                </select> 
              </div>

              <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="state">State</label>
                <select class="custom-select form-control" id="state" name="state">
              
                </select> 
              </div>

              <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="lg">Local Govt Area</label>
                <select class="custom-select form-control" id="lg" name="lg">
              
                </select> 
              </div>

              <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="city">City</label>
                 <select class="custom-select form-control" id="city">
              
                </select>
              </div>

              <div class="form-group col-md-7 margin-bottom-sm">
                 <label for="address">Institution Address</label>
                <textarea class="custom-textarea form-control" id="address" name="address" rows="2"></textarea> 
              </div>         
            
            <div class="form-group col-md-5 margin-bottom-sm">
                 <label for="mobile">Mobile</label>
                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="mobile" required /> 
              </div>
              
              </div>
               <hr class="mb-2">
                <button type="submit" class="btn btn-primary btn-lg" id="sch-profile-btn">Add School Profile</button>
              </div>
          
       <!-- Registration form ends here -->

      </div>
      <!-- this is where modal footer is -->
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>  -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  <!-- include footer -->
<?php include 'inc/footer.php'; ?>