<?php 
//include 'inc/regSession.php';
//load classes
include 'inc/autoload.php';
include 'inc/topHeader.php';
$appform = new appForm();
?>
<title>Smarty | Upload Photo</title>
<?php include'inc/userProfileHeader.php'; ?>


<div  class="container mt-3">
<h5><i class="fa fa-wifi" aria-hidden="true"></i>
 Online Application <small class="text-muted"> It's smarter</small></h5>
<hr>

<div class="row">

<!-- include side menu -->
<?php include'inc/sidemenu.php';?>
<!--end of  side menu include-->
    
<!--    div for main content-->
<div class="col-md-6">
  <!-- div to display message -->
    <div id="output" class="output">
    </div>
    <!-- end of div to display message -->
<!--  end of output class-->
        
		<form id="my-form" action=""  method="post" enctype="multipart/form-data">
    <h2>Upload Photo</h2>
    <span>Please click on the camera icon to upload your photo</span>
    <div>
    

                <div class="form-group image-upload">

                <label for="image-file">

                  <i class="fa fa fa-camera fa-5x"></i>

                </label>
        
                <input type="file" name="image-file" class="form-control" id="image-file">

                </div>

                <div id="success-msg">
                  <p id="msg"></p>
                </div>
                
    </div>
    <!-- <input type="submit" name="upload" class="btn btn-info" id="logo-upload" value="Upload" /> -->
    <!-- <button type="button" class="btn btn-info" onclick="login()">Upload</button> -->
  </form>
<!--    form ends here-->
              <!-- md 5 row -->
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