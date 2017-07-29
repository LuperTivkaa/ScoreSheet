              <?php 
include 'inc/autoload.php';
$clientObj = new client();
?>
            <h4 class="right-menu-header">Create New Staff</h4>
            
              <div class="row newStaff">
              
              <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="email">E Mail</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Choose Email"> 
              </div>

              <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="username">User Name</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Choose Username"> 
              </div>

              <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="my-pass">Password</label>
                <input type="password" class="form-control" id="my-pass" name="my-pass" placeholder="Enter Password"> 
              </div>
    
            <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="role">Role</label>
                <select class="custom-select form-control" id="role">
                <?php 
                    $clientObj->loadRoles();
                  ?>
                </select> 
              </div>

              </div>
               <hr class="mb-2">
              <button class="btn btn-primary btn-lg" id="staff-account">Create Staff</button>
            
          
      