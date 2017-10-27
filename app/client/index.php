<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ScoreSheet| Admin </title>
    <?php include '../inc/scoresheet-header.php';?>

    <body>
        <div class="wrap">
            <?php include '../inc/scoresheet-user-profile.php';?>

            <?php include '../inc/scoresheet-school-profile.php';?>

            <?php include '../inc/scoresheet-nav-client.php';?>

            <div class="wrapper">

                <div class="primary-col">
                <div id="my-info">
                    </div>
                  <!--bootstrap Container   -->
                  <h5 class="top-header">All Student(s) List</h5>
            <div class="container">

                       <div class="row">

                        <div class="col-12 list">
                        <?php $client->initialStudentList($clientid);?>
                        </div>
                       <input type="hidden" id="row_no" value="10">
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