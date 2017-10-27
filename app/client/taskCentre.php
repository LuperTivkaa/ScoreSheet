<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ScoreSheet| Admin Task Panel </title>
    <?php include '../inc/scoresheet-header.php';?>

    <body>
        <div class="wrap">
            <?php include '../inc/scoresheet-user-profile.php';?>

            <?php include '../inc/scoresheet-school-profile.php';?>

            <?php include '../inc/scoresheet-nav-client.php';?>

            <div class="wrapper">
                              <!-- The Modal -->
                    <div id="myModal" class="modal-div">

                    <!-- Modal content -->
                    <div class="modal-content-div">
                        <span class="closex">&times;</span>

                        <div class="col-6">
                        <h6 class="top-header text-xs-center mt-3"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Scores</h6>
                        </div>
                         <div class="col-6">
                            <label for="edit-class">Select Class</label>
                            <select class="custom-select  form-control" id="edit-class">
                              <?php
                                $student->loadClass($clientid);
                              ?>
                            </select>
                            </div>
                            
                            <div class="col-6">
                            <label for="edit-subject">Subject</label>
                            <select class="custom-select  form-control" id="edit-subject">
                            </select>
                            </div>

                                <div class="col-md-6">
                                <label for="edit-scores">Scores</label>
                                <input type="text" class="form-control" id="edit-scores" name="edit-scores">
                                </div>

                            <div class="col-6">
                                <button class="submit btn btn-primary btn-md mt-3 mb-3" id="edit-ca">Edit Scores</button>
                            </div>
                            <input type="hidden" class="form-control" id="record-id" name="record-id">
                            
                    </div>

                    </div>
                <!--end new modal  -->

                <div class="primary-col">
                        <div class="aux-menu">
                            <h6> Task Sub Menu</h6>
                            <ul>
                            <li><a class="load-url" href="searchCa.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>View CA</a></li>
                            <li><a class="load-url" href="searchExam.php"><i class="fa fa-clone fa-fw" aria-hidden="true"></i>View Exam(s)</a></li>
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