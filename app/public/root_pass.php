<?php 
include '../inc/publicMainHeader.php';
?>
<!-- About container begins here -->
        <div class="container pt-2 mt-3">


        <div class="row">

          <div class="col-md-4">
          
          </div>

        <div class="col-md-4">
        <h6 class="top-header"> Welcome Client, You are almost there. Create Your root account</h6>

        <div class="row">
          <div class="form-group col-md-12">
                <input type="text" class="form-control" id="email" name="email" placeholder="Email"> 
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-12">
                <input type="username" class="form-control" id="username" name="username" placeholder="Username"> 
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-12">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password"> 
          </div>
        </div>

          <div class="row">
               <button class="btn btn-primary d-block mx-auto my-3" id="root_Btn">Create Root Account</button>
         </div>
         <div class="row">
          
         </div>
              
              <div id="error-info"></div>
        </div>

        <div class="col-md-4">
          
        </div>

        </div>

        </div>
       
        </div>
    <!-- About container ends here -->

    <?php include '../inc/publicMainFooter.php';?>

