<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ScoreSheet| Staff </title>
    <?php include '../inc/scoresheet-header.php';?>

    <body>
        <div class="wrap">
            <?php include '../inc/scoresheet-user-profile.php';?>

            <?php include '../inc/scoresheet-school-profile.php';?>

            <?php include '../inc/scoresheet-nav-staff.php';?>

            <div class="wrapper">

                <div class="primary-col">
                       <!--bootstrap Container   -->
                   <div class="container">
            
                       <div class="row">
                       <!--Div to hold card for user profile  -->
                       <div class="col-md-4">
                                <div class="card">
                                    <div class="img-div">
                                    <img src="../images/bg.jpg" alt="background image" style="width:100%">
                                    <img src="../images/avatar.jpg" alt="John" class="bg-image">
                                    </div>
                                    <!-- <img src="img.jpg" alt="John" class="bg-image" style="width:100%"> -->
                                    <div class="card-container">
                                        <span class="image-upload">
                                        <label for="image-file">
                                        <i class="fa fa-camera fa-fw" aria-hidden="true"></i>
                                        </label>
                                        <input type="file" name="image-file" class="form-control" id="image-file">
                                        </span>
                                        <h1>John Doe</h1>
                                        <p class="title">School Teacher</p>
                                        <p>Nadi Schools, Makurdi</p>
                                        <a href="#"><i class="fa fa-dribbble"></i></a>
                                        <a href="#"><i class="fa fa-twitter"></i></a>
                                        <a href="#"><i class="fa fa-linkedin"></i></a>
                                        <a href="#"><i class="fa fa-facebook"></i></a>
                                        <p><button>Contact</button></p>
                                    </div>
                                </div>
                       </div>

                       <div class="col-md-8">
                            <ul class="staff-menu">
                            <li><a class="load-url" href="newStaff.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i> New Profile</a></li>
                            <li><a class="load-url" href="staffQualification.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i> Academic Qualifications</a></li>
                             <li><a class="load-url" href="student-list.php"><i class="fa fa-eye fa-fw" aria-hidden="true"></i> Profile Preview</a></li>
                            </ul>
                            <hr class="mt-2">
                       <div id="Staff-info">
                       </div>
                       <div id="my-info">
                        </div>

                        <div id="new-content">
                    </div>
                       </div>

                        </div>
                      </div>
                  <!--end bootstrap container  -->
                    

                </div>

                <?php include '../inc/scoresheet-secondary-col.php';?>
            </div>
            <?php include '../inc/scoresheet-footer.php';?>
    </body>

</html>