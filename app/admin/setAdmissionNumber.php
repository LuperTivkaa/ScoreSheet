            <?php 
include 'inc/autoload.php';
$newStudent = new student();
?>

<!-- Enter form to create new student here -->
<div class="row mb-3">
<!--<div class="col-md-3"></div>-->
    <div class="col-md-12"><h6 class="right-menu-header text-xs-center mt-3">Generate New Numbers</h6><small>Please specify how many numbers you wish to create eg 30 as range</small></div>
<!--<div class="col-md-3"></div>-->
</div>

        
        
            <div class="row">

            <div class="form-group col-md-5">
            <label for="range">Range:</label>
                <input type="text" class="form-control" id="range" name="range" placeholder="Enter Number E.g 20">
            </div>

              
              </div>
              <button class="submit btn btn-primary" id="add-numbers">Generate Numbers</button>

              <hr>
              <div class="row">
              <div class="col-md-12 mb-3">
              <h6 class="right-menu-header text-xs-center mt-3">Admission Number Settings</h6><small>This section allows you to choose how your institution's  Admission Numbers will be represented e.g nadi/2012/0002. You can change this later if you wish.</small>
              </div>
              </div>

              <div class="row">

            <div class="form-group col-md-4">
                 <label for="prefix">Enter Prefix:</label>
                <input type="text" class="form-control" id="prefix" name="prefix" placeholder="Enter prefix">
              </div>

              <div class="form-group col-md-4">
                
                 <label for="seperator">Separator</label>
                <select class="custom-select form-control" id="seperator">
                <option>/</option>
                <option>-</option>
                </select>
              </div>
              
              </div>
              <button class="submit btn btn-primary" id="add-prefix">Create Prefix</button>


