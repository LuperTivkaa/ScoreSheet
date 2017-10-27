<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ScoreSheet| Fee Settings </title>
    <?php include '../inc/scoresheet-header.php';?>

    <body>
        <div class="wrap">
            <?php include '../inc/scoresheet-user-profile.php';?>

            <?php include '../inc/scoresheet-school-profile.php';?>

            <?php include '../inc/scoresheet-nav-client.php';?>

            <div class="wrapper">

                <div class="primary-col">
                        <div class="aux-menu">
                            <h6> Fee Settings Sub Menu</h6>
                            <ul>
                            <li><a class="load-url" href="feeItems.php"><i class="fa fa-plus-square-o fa-fw" aria-hidden="true"></i>Add Fee</a></li>
                            <li><a class="load-url" href="myFeeItems.php"><i class="fa fa-bars fa-fw" aria-hidden="true"></i>All Fee</a></li>
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