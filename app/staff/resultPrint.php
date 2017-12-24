<?php
//session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
use ScoreSheet\printRoutines;
//use \PDO;
$dbConnection = new dbConnection();
$student = new student($dbConnection);
$client = new client($dbConnection);
$staff = new staff($dbConnection);
$print = new printRoutines($dbConnection);

if ($_SERVER["REQUEST_METHOD"]=="GET")
{
//$regno = $_SESSION['ID'];
$studentid = filter_input(INPUT_GET, "studentid", FILTER_SANITIZE_NUMBER_INT);
$class = filter_input(INPUT_GET, "class", FILTER_SANITIZE_NUMBER_INT);
$session = filter_input(INPUT_GET, "session", FILTER_SANITIZE_NUMBER_INT);
$term = filter_input(INPUT_GET, "term", FILTER_SANITIZE_NUMBER_INT);
$schoolid = filter_input(INPUT_GET, "schoolid", FILTER_SANITIZE_NUMBER_INT);
}
else
{
    echo "Please submit a record";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ScoreSheet | Result Sheet</title>
    <?php include '../inc/scoresheet-header.php';
    //$schid = $_SESSION['user_info'][4];
//$newStaff = new student();
//$staffid = $_SESSION['user_info'][0];
$schid = $_SESSION['user_info'][4];
//$newStaff = new student();
$staffid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->staffUser($myroleid,$schid);
    ?>

<body>

<div class="result-content-wrapper">
    <div class="national-emblem">
        
        <img class="logo-img" src=../images/niglogo.png>
        <p>BENUE STATE GOVERNMENT</p>
        <p>MINISTRY OF EDUCATION HEADQUARTERS, MAKURDI</p>
        <p>TERMLY CONTINOUS ASSESSMENT DOSSIER</p>
    
    </div>
    <div class="school-profile-container">

                <div class="school-avatar-container">
                  <!-- <img class="school-logo" src=../images/avatar-1.jpg> -->
                    <?php
                    $staff->schoolAvatar($schid);
                    ?>
                </div>   


                <div class="school-profile">
                    <?php
                    $print->schoolProfileHeader($schoolid);
                    ?>
                </div>
                <!--end school profile div  -->

                <!--student avatar div  -->
                <?php
                    $staff->studentAvatar($studentid,$schoolid);
                ?>
                <!--end studdent avatar div  -->
                
    </div>

   <!-- student details -->
    <div class="student-profile">
         <h6>STUDENT'S INFORMATION</h6>
        <?php
        // $staff->studentAvatar(2,2);
        ?>
        
        <!--end avatar  div-->
        <div class="profile-details">
            <?php
            $print->userScoresDetails($studentid,$class,$session,$term,$schoolid);
            ?>

        </div>
           <!-- End userr score details -->
    </div>
    <!-- end student profile -->
 

<!-- beginnig of result details container -->
<div class="result-details-container background-cover">

        <h6>STUDENT'S TERMLY CONTINOUS ASSESSMENT PERFORMANCE</h6>
            <!-- Result details conatiner begins here -->
        <div class="result-details">
                <?php
                // $print->userScoresDetails(3,1,7,1,2);
                $print->resultDetails($studentid,$class,$term,$session,$schoolid)
                ?>

             <!-- Teacher Comments container section here -->
                <div class="teacher-comments-container">

                    <div class="class-teacher-name">
                        <span class="staff-comments-header">Class Teacher's Name</span>
                        <span class="staff-comments-item">
                        <?php 
                        echo $staff->classTeacher($class,$schoolid);
                        ?>
                        </span>
                    </div>

                        <div class="class-teacher-comments">
                            <span class="staff-comments-header">Class Teacher's Comments</span>
                            <span class="staff-comments-item">
                            <?php 
                            echo $print->getStaffComment($studentid,$class,$term,$session,$schoolid);
                            ?>
                            </span>
                        </div>

                            <div class="class-teacher-sign">
                                <span class="staff-comments-header">Class Teacher's Signature</span>
                                <span class="staff-comments-item">.......................................</span>
                            </div>

                </div>
                <!-- End teacher comments container section here -->

                    <!-- Begin principal-comments-container -->
                <div class="principal-comments-container">

                    <div class="principal-name">
                        <span class="staff-comments-header">Principal's Name</span>
                        <span class="staff-comments-item"></span>
                    </div>

                    <div class="principal-comments">
                        <span class="staff-comments-header">Principal's Comments</span>
                        <span class="staff-comments-item"> <?php 
                        echo $print->getHeadTeacherComment($studentid,$class,$term,$session,$schoolid);
                        ?></span>
                    </div>

                    <div class="principal-sign">
                        <span class="staff-comments-header">Principals's Signature</span>
                        <span class="staff-comments-item">.........................................</span>
                    </div>
                    
                </div>
        
    <!-- end principal comments container section -->

    <!-- item container -->
        <div class="item-container">
            <h6 class="grading-header">Key To Grading</h6>
            <div class="grading-items"><h6>A-Distinction</h6><span>75% Above</span></div>
            <div class="grading-items"><h6>B-Very Goood</h6><span>65-74</span></div>
            <div class="grading-items"><h6>C-Good</h6><span>55-64</span></div>
            <div class="grading-items"><h6>D-Fair</h6><span>40-54</span></div>
            <div class="grading-items"><h6>E-Poor</h6><span>39 Below</span></div> 
        </div>
    <!-- end Item container -->

  </div>
<!-- Result details ends here -->
</div>
<!--End result details container  -->

<!-- Domain Ratings -->
<div class="domain-ratings">
                
                <div class="traits-items">
                    <h6 class="domain-ratings-header">Affective Domain</h6>
                    <?php
                    $print->resultAffectiveTraits($studentid,$schoolid);
                    ?>
                </div>
            
                <div class="traits-items">
                    <h6 class="domain-ratings-header">Psychomotor Domain</h6>
                    <?php
                    $print->resultPsychomotorSkills($studentid,$schoolid);
                    ?>
                </div>

                <div class="traits-items">
                    <h6 class="domain-ratings-header">Key To Rating</h6>
                    <?php
                    $print->keyToRatings();
                    ?>
                </div>
</div>
        <!-- domain ratings container ends here -->


    <!-- <div class="comments-section">
        <div class="teacher-comments-container">

            <div class="class-teacher-name">
            <span class="staff-comments-header">Class Teacher's Name</span>
            <span class="staff-comments-item">
                <?php 
                //echo $staff->classTeacher($class,$schoolid);
                ?>
            </span>
            </div>

            <div class="class-teacher-comments">
            <span class="staff-comments-header">Class Teacher's Comments</span>
            <span class="staff-comments-item">
                <?php 
                //echo $print->getStaffComment($studentid,$class,$term,$session,$schoolid);
                ?>
            </span>
            </div>

            <div class="class-teacher-sign">
            <p class="staff-comments-header">Class Teacher's Signature</p>
            </div>

        </div>

        <div class="principal-comments-container">

            <div class="principal-name">
            <span class="staff-comments-header">Principal's Name</span>
            <span class="staff-comments-item">
               
            </span>
            </div>

            <div class="principal-comments">
                <span class="staff-comments-header">Principal's Comments</span>
                <span class="staff-comments-item"> <?php 
                //echo $print->getHeadTeacherComment($studentid,$class,$term,$session,$schoolid);
                ?></span>
            </div>

            <div class="principal-sign">
               <span class="staff-comments-header">Principals's Signature</span>
            </div>
            
        </div>
    </div> -->

    <!-- <div class="item-container">
        <h6 class="grading-header">Key To Grading</h6>
    
    <div class="grading-items"><h6>A-Distinction</h6><span>75% Above</span></div>
    <div class="grading-items"><h6>B-Very Goood</h6><span>65-74</span></div>
    <div class="grading-items"><h6>C-Good</h6><span>55-64</span></div>
    <div class="grading-items"><h6>D-Fair</h6><span>40-54</span></div>
    <div class="grading-items"><h6>E-Poor</h6><span>39 Below</span></div>
    
    </div> -->

</div>

</body>

</html>