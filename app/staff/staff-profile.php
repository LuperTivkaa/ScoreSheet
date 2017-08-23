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
                                    <img src="../images/bg.jpg" alt="John" class="bg-image" style="width:100%">
                                    </div>
                                    <!-- <img src="img.jpg" alt="John" class="bg-image" style="width:100%"> -->
                                    <div class="card-container">
                                    <h1>John Doe</h1>
                                    <p class="title">CEO & Founder, Example</p>
                                    <p>Harvard University</p>
                                    <a href="#"><i class="fa fa-dribbble"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-linkedin"></i></a>
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <p><button>Contact</button></p>
                                    </div>
                                </div>
                       </div>

                       <div class="col-md-8">
                            <ul>
                            <li><a class="load-url" href=""><i class="fa fa-plus fa-fw" aria-hidden="true"></i> New Profile</a></li>
                            <li><a class="load-url" href=""><i class="fa fa-male fa-fw fa-fw" aria-hidden="true"></i> Edit Profile</a></li>
                            <li><a class="load-url" href=""><i class="fa fa-sort-numeric-asc fa-fw" aria-hidden="true"></i> Assign Admission Number</a></li>
                             <li><a class="load-url" href="student-list.php"><i class="fa fa-th-list fa-fw" aria-hidden="true"></i>Student's Preview</a></li>
                            </ul>
                       <div id="Staff-info">
                       </div>
                       </div>

                        </div>
                      </div>
                  <!--end bootstrap container  -->
                    <div id="my-info">
                    </div>

                    <div id="new-content">
                    </div>

                </div>

                <?php include '../inc/scoresheet-secondary-col.php';?>
            </div>
            <?php include '../inc/scoresheet-footer.php';?>
    </body>

</html>