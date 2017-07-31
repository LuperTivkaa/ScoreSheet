<?php 
include 'inc/regSession.php';
//load classes
include 'inc/autoload.php';
include 'inc/topHeader.php';
$newClient= new client();
$clientid = $_SESSION['user_info'][4];
?>
<title>ScoreSheet | New Ticket</title>
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

<P><button type="button" class="btn btn-info btn-md my-3" data-toggle="modal" data-target="#register"><i class="fa fa-plus" aria-hidden="true"></i>
Create Ticket</button></P>

<!-- display message -->
<div id="info">
</div>
  <!-- div to display new content -->
<div id="new-content">
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


<div id="register" class="modal fade">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-xs-center text-white">
      <h4 class="modal-title">Create New Ticket</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <div class="row">
    
            <div class="form-group col-md-6">
                 <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title">  
              </div>

              <div class="form-group col-md-6">
                 <label for="priority">Priority</label>
                <select class="custom-select form-control" id="priority" name="priority">
                <option>High</option>
                <option>Low</option>
                <option>Trivial</option>
                </select> 
              </div>

    
              <div class="form-group col-md-12">
                 <label for="notes">Notes</label>
                <textarea class="custom-textarea form-control" id="notes" name="notes" rows="7"></textarea> 
              </div>         
            
            </div>
               <hr class="mb-2">
                <button type="submit" class="btn btn-primary btn-lg" id="my-ticket">Send Ticket</button>
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