<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ScoreSheet| School DashBoard </title>
    <?php include '../inc/scoresheet-header.php';?>

    <body>
        <div class="wrap">
            <?php include '../inc/scoresheet-user-profile.php';?>

            <?php include '../inc/scoresheet-school-profile.php';?>

            <?php include '../inc/scoresheet-nav-client.php';?>

            <div class="wrapper">

                <div class="primary-col">
                        <div class="aux-menu">
                            <h6> My School Sub Menu</h6>
                            <ul>
                            <li><a class="all-students" href="allStudents.php"><i class="fa fa-paper-plane fa-fw" aria-hidden="true"></i> All Students</a></li>
                            <li><a class="birthdays" href="birthDayList.php"><i class="fa fa-birthday-cake fa-fw" aria-hidden="true"></i> Birthday</a></li>
                            <li><a class="finances" href=""><i class="fa fa-line-chart fa-fw" aria-hidden="true"></i> Finances</a></li>
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