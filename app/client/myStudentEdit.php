<?php
//session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
//use \PDO;
$dbConnection = new dbConnection();
$student = new student($dbConnection);
$client = new client($dbConnection);
$staff = new staff($dbConnection);
 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ScoreSheet| School Student </title>
    <?php include '../inc/scoresheet-header.php';
    $clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->clientUser($myroleid,$clientid); 

if ($_SERVER["REQUEST_METHOD"]=="GET")
{
//$regno = $_SESSION['ID'];
$studentid = filter_input(INPUT_GET, "studentid", FILTER_SANITIZE_NUMBER_INT);
// $class = filter_input(INPUT_GET, "class", FILTER_SANITIZE_NUMBER_INT);
// $session = filter_input(INPUT_GET, "session", FILTER_SANITIZE_NUMBER_INT);
// $term = filter_input(INPUT_GET, "term", FILTER_SANITIZE_NUMBER_INT);
// $schoolid = filter_input(INPUT_GET, "schoolid", FILTER_SANITIZE_NUMBER_INT);
$output = $client->studentEditProfile($studentid,$clientid);
foreach($output as $row => $key)
    {
        $surname = $key['Surname'];
        $firstname = $key['FirstName'];
        $lastname = $key['LastName'];
        $homeAdd  = $key['HomeAdd'];
        $contactAdd = $key['ContactAdd'];
        $mail = $key['Mail'];
        $mobile = $key['Mobile'];
    }
}
else
{
    echo "Please submit a record";
}

    ?>

    <body>
        <div class="wrap">
            <?php include '../inc/scoresheet-user-profile.php';?>

            <?php include '../inc/scoresheet-school-profile.php';?>

            <?php include '../inc/scoresheet-nav-client.php';?>

            <div class="wrapper">

                <div class="primary-col">
                          
                    <div id="my-info">
                    </div>
                     <!--You can put content here inside the primary column  -->

                    <!--end custom content  -->
                    <script>
                    //$("#new-content").on('click', '#datepicker', function(e){
                     //e.preventDefault();
                    $(function() {
                    $( "#datepicker" ).datepicker();
                     }); 
                </script>

                    <div id="student-edit">
                    <div class="container pt-2 mt-3">

                        <!--Other row for heading  -->
                        <div class="row">
                            <div class="col-md-6">
                            <h4 class="top-header"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Student's Personal Information</h4>
                            </div>

                            <div class="col-md-6">

                            </div>
                        </div>
                        <!--another row ends  -->

  <!--containing row  -->
  <div class="row">

      <!--first column  -->
     <div class="col-md-4">

              <div class="form-group col-md-12">
                 <label for="surname">Surname:</label>
                <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $surname;?>" placeholder="surname"> 
              </div>

              <div class="form-group col-md-12">
                    <label for="sex">Gender:</label>
                  <select class="custom-select form-control" id="sex" name="sex">
                      <option>Male</option>
                      <option>Female</option>
                  </select> 
              </div>

              <div class="form-group col-md-12">
                <label for="stud-state">State:</label>
                <select class="custom-select form-control" id="stud-state">                         
                </select> 
              </div>

              <div class="form-group col-md-12">
                 <label for="religion">Religion</label>
                <select class="custom-select form-control" id="religion" name="religion">
                      <option>Christianity</option>
                      <option>Muslim</option>
                      <option>Other</option>                          
                </select> 
              </div>

            <div class="form-group col-md-12">
                <label for="mobile">Mobile [Optional]:</label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $mobile;?>" placeholder="Mobile"> 
            </div>

     </div>
     <!--end first ccolumn  -->


      <!--End second column  -->
     <div class="col-md-4">

              <div class="form-group col-md-12">
                 <label for="firstname">First Name:</label>
                  <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $firstname;?>" placeholder="Firstname"> 
                  <input type="hidden" class="form-control" id="studid" name="studid" value="<?php echo $studentid;?>"> 
              </div>

              <div class="form-group col-md-12">
                <label for="datepicker">Date of Birth:</label>
                <input type="text" class="form-control" id="datepicker"> 
              </div>

              <div class="form-group col-md-12">
                 <label for="stud-lg">Lga:</label>
                <select class="custom-select form-control" id="stud-lg">                         
                </select> 
              </div>

              <div class="form-group col-md-12">
                 <label for="address1">Residential/Contact Address:</label>
                <textarea class="custom-textarea form-control" id="address1" name="address1" rows="1"></textarea> 
              </div>

              <div class="form-group col-md-12">
                 <label for="mail">Email [Optional]:</label>
                <input type="email" class="form-control" id="mail" name="mail" value="<?php echo $mail;?>" placeholder="Email optional"> 
              </div>

     </div>
     <!--End second column  -->

      <!--Third column  -->
     <div class="col-md-4">

              <div class="form-group col-md-12">
                 <label for="lastname">Last Name [Optional]:</label>
                <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $lastname;?>" placeholder="Lastname"> 
              </div>

              <div class="form-group col-md-12">
                 <label for="stud-nation">Nationality:</label>
                <select class="custom-select form-control" id="stud-nation">
                <?php
                  $client->loadNationality();
                    ?>
                </select> 
              </div>

               <div class="form-group col-md-12">
                 <label for="stud-city">Town/City:</label>
                <select class="custom-select form-control" id="stud-city">
                </select> 
              </div>

                <div class="form-group col-md-12">
                 <label for="address2">Permanent/Home Address:</label>
                <textarea class="custom-textarea form-control" id="address2" name="address2" rows="1"></textarea> 
              </div>

              
              <div class="form-group col-md-12">
                 <label for="bloodgroup">Blood Group</label>
                <select class="custom-select form-control" id="blood-group" name="blood-group">
                      <option>A+</option>
                      <option>A-</option>
                      <option>AB</option>
                      <option>B+</option>
                      <option>O+</option>
                      <option>O-</option>                          
                    </select> 
              </div>
      
     </div>
     <!--end third column  -->



  </div>
  <!--end containing row  -->

  <!--Other row for heading  -->
  <div class="row">
    <div class="col-md-6">
      <h4 class="top-header">Student's Educational Information</h4>
    </div>

    <div class="col-md-6">

    </div>
  </div>
  <!--another row ends  -->


  <!--Another containig row  -->
  <div class="row">

    <div class="col-md-4">

        <div class="form-group col-md-12">
                 <label for="class-admitted">Class Admitted:</label>
                <select class="custom-select form-control" id="class-admitted" name="class-admitted">
                <?php
                  $client->loadClass($clientid);
                    ?>
                </select> 
        </div>

    </div>


    <div class="col-md-4">

      <div class="form-group col-md-12">
                 <label for="session">Session Admitted:</label>
                <select class="custom-select form-control" id="session" name="session">
                  <?php
                  $client->loadSession($clientid);
                  ?>
                </select> 
      </div>

    </div>


    <div class="col-md-4">

      <div class="form-group col-md-12">
                 <label for="adm-type">Admission Type:</label>
                <select class="custom-select form-control" id="adm-type" name="adm-type">
                <option>New Admission</option>
                <option>Transfer</option>
                </select> 
      </div>

    </div>

  </div>
  <!--End another containing row  -->

  <!--Other row for heading  -->
  <div class="row">
    <div class="col-md-3">
    <button class="submit btn btn-primary mb-3"  id="edit-student-btn">Save Changes</button>

    </div>

    <div class="col-md-6">

    </div>
    <div class="col-md-3">

    </div>

  </div>
  <!--another row ends  -->

</div>
<!--end container  -->

                    </div>

                </div>

                <?php include '../inc/scoresheet-secondary-col.php';?>
            </div>
            <?php include '../inc/scoresheet-footer.php';?>
    </body>

</html>