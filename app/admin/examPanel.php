<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ScoreSheet| Exam Task Panel </title>
    <?php include '../inc/scoresheet-header.php';?>

    <body>
        <div class="wrap">
            <?php include '../inc/scoresheet-user-profile.php';?>

            <?php include '../inc/scoresheet-school-profile.php';?>

            <?php include '../inc/scoresheet-nav.php';?>

            <div class="wrapper">
                             <!-- The Modal -->
                    <div id="myModal" class="modal-div">

                    <!-- Modal content -->
                    <div class="modal-content-div">
                        <span class="closex">&times;</span>

                    <div class="col-8">
                        <h6 class="top-header text-xs-center mt-3"><i class="fa fa-plus-circle" aria-hidden="true"></i>Add Head Teacher's Comments  
                        </h6>
                        <p class="display">
                            <button type="button" class="custom-btn" id="studcomments">Comments</button>
                        </p>
                        <p id="modal_error"></p>  
                         
                    </div>

                        <!--Begin comments div  -->
                        
                        <div class="comments-div">
                            <div class="col-8">
                            <h6 class="highlight top-header text-xs-center mt-3">Add Comments</h6>
                            </div>

                            <div class="col-8">
                            <label for="comment-id">Enter comment</label>
                            <textarea class="form-control" id="comment-id" rows="2"></textarea>
                            <span id="textRemaining">50</span> Characters remaining
                            </div>
                            
                            <div class="col-4">
                        <button class="submit btn btn-primary btn-md mt-3 mb-3" id="admin-comments"><i class="fa fa-plus" aria-hidden="true"></i> Add Comments</button>
                            </div>
                        </div>
                        <!--end comments div  -->
                        
                            <input type="hidden" class="form-control" id="record-id" name="record-id">
                            <hr>
                            <div class="col-6" id="modal-list">
                            
                            </div>
                            
                    </div>

                    </div>
                <!--end new modal  -->

                <div class="primary-col">
                        <div class="aux-menu">
                            <h6> Exam Task Sub Menu</h6>
                            <ul>
                            <li><a class="load-url" href="findPublishedResult.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>Published Result</a></li>
                            <li><a class="load-url" href="resultApproval.php"><i class="fa fa-clone fa-fw" aria-hidden="true"></i>Result Approval</a></li>
                            <li><a class="load-url" href="viewResult.php"><i class="fa fa-clone fa-fw" aria-hidden="true"></i>View Result</a></li>
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