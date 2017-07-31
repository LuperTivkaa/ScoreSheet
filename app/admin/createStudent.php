<?php 
include 'inc/regSession.php';
//load classes
include 'inc/autoload.php';
include 'inc/topHeader.php';
$newStudent = new student();
$clientid = $_SESSION['user_info'][0];
?>
<title>ScoreSheet | Student Profile</title>
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
  

 <div class="row mb-3">
<!--<div class="col-md-3"></div>-->
    <div class="col-md-12"><h4 class="right-menu-header text-xs-center">New Institutional Account</h4></div>
<!--<div class="col-md-3"></div>-->
    </div>

    <!--progress bar div    -->
<div class="progress mb-3">
    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
  </div>
<!--    end of prgress bar -->

<form id="regiration_form">  
<fieldset class="form-group">
  <h5 class="right-menu-header">Step 1: Personal Information</h5>
        
    <div class="row">
            
             <div class="form-group col-md-4">
                 <label for="surname">Surname:</label>
                <input type="text" class="form-control" id="surname" name="surname" placeholder="surname"> 
              </div>
            
            <div class="form-group col-md-4">
                 <label for="firstname">First Name:</label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname"> 
              </div>

              <div class="form-group col-md-4">
                 <label for="lastname">Last Name:</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname"> 
              </div>

              <div class="form-group col-md-4">
                 <label for="religion">Religion</label>
                <select class="custom-select form-control" id="religion" name="religion">
                      <option>Christianity</option>
                      <option>Muslim</option>
                      <option>Other</option>                          
                    </select> 
              </div>
            
             <div class="form-group col-md-4">
                 <label for="nation">Nationality:</label>
                <select class="custom-select form-control" id="nation">
                <?php
                    $newStudent->loadNationality();
                    ?>
                </select> 
              </div>

              <div class="form-group col-md-4">
                 <label for="state">State:</label>
                <select class="custom-select form-control" id="state">                         
                    </select> 
              </div>

              <div class="form-group col-md-4">
                 <label for="lg">Lga:</label>
                <select class="custom-select form-control" id="lg">                         
                    </select> 
              </div>

            <div class="form-group col-md-3">
                 <label for="city">City:</label>
                <select class="custom-select form-control" id="city">
                </select> 
              </div>

              <div class="form-group col-md-5">
                 <label for="address1">Contact Address:</label>
                <textarea class="custom-textarea form-control" id="address1" name="address1" rows="1"></textarea> 
              </div>
              
            <div class="form-group col-md-5">
                 <label for="address2">Permanent Home Address:</label>
                <textarea class="custom-textarea form-control" id="address2" name="address2" rows="1"></textarea> 
              </div>

              <div class="form-group col-md-4">
                 <label for="mail">Email:</label>
                <input type="email" class="form-control" id="mail" name="mail" placeholder="Email optional"> 
              </div>

             <div class="form-group col-md-3">
                 <label for="mobile">Mobile:</label>
                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile"> 
              </div>
            
              </div>
              <input type="button" name="" class="next btn btn-info" value="Next" />
              </fieldset>

<fieldset class="form-group">
  <h5 class="right-menu-header">Step 2: Bio Data Information</h5>
        
    <div class="row">
            
             <div class="form-group col-md-4">
                 <label for="sex">Gender:</label>
                <select class="custom-select form-control" id="sex" name="sex">
                    <option>Male</option>
                      <option>Female</option>
                </select> 
              </div>
            <div class="form-group col-md-4">
                 <label for="datepicker">Date of Birth:</label>
                <input type="text" class="form-control" id="datepicker"> 
              </div>

              <div class="form-group col-md-4">
                 <label for="bloodgroup">Blood Group</label>
                <select class="custom-select form-control" id="blood-group" name="blood-group">
                      <option>A+</option>
                      <option>A-</option>
                      <option>O+</option>
                      <option>O-</option>                          
                    </select> 
              </div>
            
              </div>
              <input type="button" name="previous" class="previous btn btn-default" value="Previous" />
              <input type="button" name="" class="next btn btn-info" value="Next" />
              </fieldset>


<fieldset class="form-group">
  <h5 class="right-menu-header">Step 3: Educational Information</h4>
        
    <div class="row">
            
             <div class="form-group col-md-6">
                 <label for="dept">Class:</label>
                <select class="custom-select form-control" id="class" name="class">
                </select> 
              </div>
            <div class="form-group col-md-6">
                 <label for="arm">Class Description:</label>
                <select class="custom-select form-control" id="arm" name="arm">  
                </select> 
              </div>

              </div>
              <input type="button" name="previous" class="previous btn btn-default" value="Previous" />
            <input  type="button" name="submit" id="form_submit" class="submit btn btn-success" value="Submit" onclick="submitForm()"/>
              </fieldset>

              </form>


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