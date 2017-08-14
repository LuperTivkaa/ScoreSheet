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

            <?php include '../inc/scoresheet-nav.php';?>

            <div class="container">

                <div class="primary-col">
                    <p>This iisi iisn is isins kisghjghj jjkjkhjk jkjhkjh jbkjhkjh kjhkjhkjh kjbkjhkjhbkjhkjhkjh nmmn nn</p>
                    <p>this </p>
                    <!--outside content row  -->
                    <div class="row">
                        <!--column 8  -->
                        <div class="col-md-8">
                            <!--content row  -->
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="student">Select Student</label>
                                    <select class="custom-select form-control" id="student">
                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="student">Select Student</label>
                                    <select class="custom-select form-control" id="student">
                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="student">Select Student</label>
                                    <select class="custom-select form-control" id="student">
                    </select>
                                </div>
                            </div>
                            <!--end content row  -->


                        </div>
                        <!--end cloumn 8  -->

                        <div class="col-md-4">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="add-no">Admission Number</label>
                                    <select class="custom-select form-control" id="add-no" disabled>
                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end outside row  -->
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