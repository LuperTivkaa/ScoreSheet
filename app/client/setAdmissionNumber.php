             <?php 
// include 'inc/autoload.php';
// $newStudent = new student();
?> 
<div class="row mb-3">
<!--<div class="col-md-3"></div>-->
    <div class="col-md-12"><h5 class="top-header text-xs-center mt-3">Generate New Numbers</h5><small>Please specify how many numbers you wish to create eg 30 as range</small></div>
<!--<div class="col-md-3"></div>-->
</div>

        
        
            <div class="row">

            <div class="form-group col-md-12">
            <label for="range">Range:</label>
                <input type="text" class="form-control" id="range" name="range" placeholder="Enter Number E.g 20">
            </div>

              
              </div>
              <div class="col-md-4">
              <button class="submit btn btn-primary" id="add-numbers">Generate Numbers</button>
              </div>

              <hr>
              <div class="row">
              <div class="col-md-12 mb-3">
              <h5 class="top-header text-xs-center mt-3">Admission Number Settings</h5><small>This section allows you to choose how your institution's  Admission Numbers will be represented e.g nadi/std. You can change this later if you wish.</small>
              </div>
              </div>

              <div class="row">

                 <div class="form-group col-md-12">
                 <label for="prefix">Enter Prefix:</label>
                <input type="text" class="form-control" id="prefix" name="prefix" placeholder="Enter prefix eg nad/std">
              </div>

              </div>
              <div class="col-md-4">
              <button class="submit btn btn-primary mb-3" id="add-prefix">Create Prefix</button>
              </div>


