            <?php
include 'inc/regSession.php';
include 'inc/autoload.php';
$newStaff = new student();
$clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];
?>

<!-- Enter form to create new student here -->
<div class="row mb-3">
<!--<div class="col-md-3"></div>-->
    <div class="col-md-12"><h6 class="right-menu-header text-xs-center mt-3">Add CA</h6></div>
<!--<div class="col-md-3"></div>-->
</div>


        <!-- ADD NEW CA-->
    <div class="row">

            <div class="form-group col-md-4">
                 <label for="student-class">Select Class </label>
                <select class="custom-select  form-control" id="student-class">
                <?php
                $newStaff->loadClass($clientid);
                  ?>
                </select>
              </div>

              <div class="form-group col-md-4">

                 <label for="arm">Class Arm</label>
                <select class="custom-select  form-control" id="arm">

                </select>
              </div>

              <div class="form-group col-md-4">
                <label for="regno">Reg Number</label>
                <input type="text" class="form-control" id="regno" name="regno" placeholder="Reg Number">
              </div>

              <div class="form-group col-md-4">

                 <label for="list-subject">Select Subject</label>
                <select class="custom-select form-control" id="list-subject">
                <?php
               $newStaff->loadSubject($userid);
               ?>
                </select>
              </div>

              <div class="form-group col-md-4">
                <label for="scores">Enter Scores:</label>
                <input type="text" class="form-control" id="scores" name="scores" placeholder="Enter Scores">
              </div>

              </div>
              <button class="submit btn btn-primary btn-md" id="add-ca">Enter Scores</button>
