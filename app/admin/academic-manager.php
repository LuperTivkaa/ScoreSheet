<?php
//session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
//use \PDO;
$dbConnection = new dbConnection();
$student = new student($dbConnection);
$client = new client($dbConnection);
$staff = new staff($dbConnection);
//$jobmanager = new manager($dbConnection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ScoreSheet| Academic Settings Manager</title>
    <?php include '../inc/scoresheet-header.php';
    $schid = $_SESSION['user_info'][4];
//$newStaff = new student();
$staffid = $_SESSION['user_info'][0];
$roleid = $_SESSION['user_info'][2];
$staff->adminUser($roleid,$schid);
    
    ?>

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
                                         <h6 class="top-header text-xs-center mt-3"><i class="fa fa-plus-circle" aria-hidden="true"></i>Edit Menu  
                                         </h6>
                                         <p class="display">
                                            
                                         </p>
                                         <p id="modal_error"></p>  
                                          
                                        </div>
                 
                                         <!--Edit term div -->
                                         <div class="term-div hide-me">
                 
                                             <div class="col-8">
                                             <h6 class="highlight top-header text-xs-center mt-3">Edit Academic Term</h6>
                                             </div>
                 
                                             <div class="col-8">
                                             <label for="editterm">Edit Term</label>
                                             <input type="text" class="form-control" id="editterm" name="editterm" placeholder="Enter Term"> 
                                             </div>
                                             
                                         <div class="col-4">
                                         <button class="submit btn btn-primary btn-md mt-3 mb-3" id="edit-term"><i class="fa fa-pencil" aria-hidden="true"></i> Update Term</button>
                                             </div>
                                         </div>
                                         <!--End edit term -->
                 
                                         <!--Begin edit subject div  -->
                                         
                                         <div class="subject-div hide-me">
                                             <div class="col-8">
                                             <h6 class="highlight top-header text-xs-center mt-3"> Update Subject</h6>
                                             </div>
                 
                                             <div class="col-8">
                                              <label for="editsubject">Subject Name:</label>
                                             <input type="text" class="form-control" id="editsubject" name="editsubject" placeholder="Enter Subject">
                                             </div>
                                             
                                         <div class="col-4">
                                         <button class="submit btn btn-primary btn-md mt-3 mb-3" id="edit-subject"><i class="fa fa-pencil" aria-hidden="true"></i> Update Subject</button>
                                         </div>
                                         </div>
                                         <!--end edit subject div  -->
                                         <!--begin edit class  -->
                                         <div class="class-div hide-me">
                                             <div class="col-8">
                                             <h6 class="highlight top-header text-xs-center mt-3">Edit Class</h6>
                                             </div>
                 
                                             <div class="col-8">
                                              <label for="editclass">Class Name:</label>
                                             <input type="text" class="form-control" id="editclass" name="editclass" placeholder="Enter Class">
                                             </div>
                                             
                                         <div class="col-4">
                                         <button class="submit btn btn-primary btn-md mt-3 mb-3" id="edit-class"><i class="fa fa-pencil" aria-hidden="true"></i> Update Class</button>
                                         </div>
                                         </div>
                                         <!--end edit class  -->
                 
                                         <!--Begin edit prefix settings  -->
                                         <div class="prefix-div hide-me">
                                             <div class="col-8">
                                             <h6 class="highlight top-header text-xs-center mt-3">Edit Prefix Settings</h6>
                                             </div>
                 
                                             <div class="col-8">
                                              <label for="editprefix">Prefix Settings:</label>
                                             <input type="text" class="form-control" id="editprefix" name="editprefix" placeholder="Enter Prefix">
                                             </div>
                                             
                                         <div class="col-4">
                                         <button class="submit btn btn-primary btn-md mt-3 mb-3" id="edit-prefix"><i class="fa fa-pencil" aria-hidden="true"></i> Update Prefix</button>
                                         </div>
                                         </div>
                 
                                         <!--End edit prefix settings  -->
                 
                                         <!--edit class teacher subjects  -->
                 
                                         <div class="classteacher-div hide-me">
                                             <div class="col-8">
                                             <h6 class="highlight top-header text-xs-center mt-3">Edit Class Teacher</h6>
                                             </div>
                 
                                                 <div class="form-group col-md-8 margin-bottom-sm">
                                                 <label for="school-class">Class</label>
                                                 <select class="custom-select form-control" id="school-class">
                                                 <?php 
                                                     $client->loadClass($clientid);
                                                 ?>
                                                 </select> 
                                             </div>
                                             
                                         <div class="col-4">
                                         <button class="submit btn btn-primary btn-md mt-3 mb-3" id="edit-class-teacher"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Class Teacher</button>
                                         </div>
                                         </div>
                                         <!--end edit class teacher  -->
                 
                 
                                         <!--edit staff subjects  -->
                 
                                         <div class="staffsubjects-div hide-me">
                                             <div class="col-8">
                                             <h6 class="highlight top-header text-xs-center mt-3">Edit Staff Subject(s)</h6>
                                             </div>
                 
                                                 <div class="form-group col-md-8 margin-bottom-sm">
                                                 <label for="sch-class">Class</label>
                                                 <select class="custom-select form-control" id="sch-class">
                                                 <?php 
                                                     $client->loadClass($clientid);
                                                 ?>
                                                 </select> 
                                             </div>
                                     
                                             <div class="form-group col-md-8 margin-bottom-sm">
                                                 <label for="sch-subject">Subject</label>
                                                 <select class="custom-select form-control" id="sch-subject">
                                                 </select> 
                                             </div>
                                             
                                         <div class="col-4">
                                         <button class="submit btn btn-primary btn-md mt-3 mb-3" id="edit-staff-subject"><i class="fa fa-pencil" aria-hidden="true"></i> Update Staff Subjects</button>
                                         </div>
                                         </div>
                                         <!--end edit staff subject  -->
                 
                                         <!--Begin session div  -->
                                         <div class="session-div hide-me">
                                             <div class="col-8">
                                             <h6 class="highlight top-header text-xs-center mt-3"> Update Session</h6>
                                             </div>
                 
                                             <div class="col-8">
                                             <label for="editsession">Edit Session</label>
                                             <input type="text" class="form-control" id="editsession" name="editsession" placeholder="Enter Session"> 
                                             </div>
                 
                                             <div class="col-4">
                                             <button class="submit btn btn-primary btn-md mt-3 mb-3" id="edit-session"><i class="fa fa-plus" aria-hidden="true"></i> Update Session</button>
                                             </div>
                 
                 
                                             </div>
                                             <input type="hidden" class="form-control" id="record-id" name="record-id">
                                             <input type="hidden" class="form-control" id="item-value" name="item-value">
                                             <input type="hidden" class="form-control" id="staffID" name="staffID">
                                             <hr>
                                             <div class="col-6" id="modal-list">
                                             </div>
                                             </div>
                 
                                     </div>
                                 <!--end new modal  -->

                <div class="primary-col">
                        <div class="aux-menu">
                            <h6> Manage Academic Settings Sub Menu</h6>
                            <ul>
                            <li><a class="load-url" href="myTerms.php"><i class="fa fa-paper-plane fa-fw" aria-hidden="true"></i>All Terms</a></li>
                            <li><a class="load-url" href="mySessions.php"><i class="fa fa-bars fa-fw" aria-hidden="true"></i> All Sessions</a></li>
                            <li><a class="load-url" href="mySubjects.php"><i class="fa fa-paperclip fa-fw" aria-hidden="true"></i>Manage Subjects</a></li>
                            <li><a class="load-url" href="subjectTeachers.php"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Subject Teachers</a></li>
                            <li><a class="load-url" href="classTeachers.php"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Class Teachers</a></li>
                            <li> <a class="load-url" href="schoolClasses.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>Manage Classes</a></li>
                            <li><a class="load-url" href="myAdmNoSettings.php"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> Manage Prefix Settings</a></li>
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