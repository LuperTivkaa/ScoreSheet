<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ScoreSheet| Academic Routines </title>
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
                       <div class="col-md-12 pl-0">
                            <ul class="staff-menu">
                            <li><a class="load-url" href="createCa.php"><i class="fa fa-eraser fa-fw" aria-hidden="true"></i> New CA Score</a></li>
                            <li><a class="load-url" href="searchCa.php"><i class="fa fa-bolt fa-fw" aria-hidden="true"></i> Search  CA</a></li>
                             <li><a class="load-url" href="assessmentSheet.php"><i class="fa fa-tags fa-fw" aria-hidden="true"></i> Assessment Sheet</a></li>
                             
                            </ul>
                            <hr class="mt-2">                
                       </div>
                       <!--inner div  -->
                        </div> 
                           <!--row  -->
                           <div id="Staff-info">
                           </div>

                          <div id="my-info">
                          </div>

                          <div id="new-content">
                          </div>
                          
                      </div>
                      <!--container  -->
                  <!--end bootstrap container  -->
                    

                </div>

                <?php include '../inc/scoresheet-secondary-col.php';?>
            </div>
            <?php include '../inc/scoresheet-footer.php';?>
    </body>

</html>