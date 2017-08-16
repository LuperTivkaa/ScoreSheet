<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ScoreSheet| School Student </title>
    <?php include '../inc/scoresheet-header.php';?>

    <body>
        <div class="wrap">
            <?php include '../inc/scoresheet-user-profile.php';?>

            <?php include '../inc/scoresheet-school-profile.php';?>

            <?php include '../inc/scoresheet-nav.php';?>

            <div class="wrapper">

                <div class="primary-col">
                        <div class="aux-menu">
                            <h6> My Student Sub Menu</h6>
                            <ul>
                            <li><a class="load-url" href="newStudent.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i> New Student</a></li>
                            <li><a class="load-url" href="studentParent.php"><i class="fa fa-male fa-fw fa-fw" aria-hidden="true"></i>Add Parent</a></li>
                            <li><a class="load-url" href="createAdmissionNumber.php"><i class="fa fa-sort-numeric-asc fa-fw" aria-hidden="true"></i> Assign Admission Number</a></li>
                            </ul>   
                        </div>  
                    <!--You can put content here inside the primary column  -->

                    <!--end custom content  -->
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