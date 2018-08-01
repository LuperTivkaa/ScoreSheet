<?php
set_time_limit(600);
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

<body onload="window.print()">

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
                    $staff->schoolAvatar($schoolid);
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
 

<!-- Begin main result container -->
<div class="main-result-container">
      <h6>STUDENT'S TERMLY CONTINOUS ASSESSMENT PERFORMANCE</h6>
      <!-- begin student  performance container -->
    <div class="student-performance-container">
                <?php
                $print->resultDetails($studentid,$class,$term,$session,$schoolid);
                ?>
            
    </div>
    <!-- End student performancen container -->
    <?php if($term==33)
        {
            echo "<h6>STUDENT'S ANNUAL RESULT SUMMARY</h6>";
        }
    ?>
    <div class="profile-details">
            <?php
            if($term==33){
            $print->annualScoresDetails($studentid,$class,$session,$schoolid);
            }
            ?>
        </div>
    <!-- Begin Annual Summary Reports -->
    <div class="student-performance-container">
                <?php
                if($term == 33){
                $print->studentAnnualResultSummary($studentid,$class,$session,$schoolid);
                }
                ?>
            
    </div>
    <!-- End Annual Summary Reports -->
    
    <!-- Begin Teacher comments container -->
    <div class="teacher-comments-container">

                    <div class="class-teacher-name">
                        <p class="staff-comments-header">Class Teacher's Name</p>
                        <p class="staff-comments-item">
                        
                        <?php 
                        echo $staff->classTeacher($class,$schoolid);
                        ?>
                        </p>
                    </div>

                        <div class="class-teacher-comments">
                            <p class="staff-comments-header">Class Teacher's Comments</p>
                            <p class="staff-comments-item">
                            
                            <?php 
                            echo $print->getStaffComment($studentid,$class,$term,$session,$schoolid);
                            ?>
                            </p>
                        </div>

                            <div class="class-teacher-sign">
                                <p class="staff-comments-header">Class Teacher's Signature</p>
                                <p class="staff-comments-item">.......................................</p>
                            </div>
    </div>
    <!-- end teacher comments container -->

    
    <!-- Begin principal comments conatiner -->
        <div class="principal-comments-container">
                    <div class="principal-name">
                        <p class="staff-comments-header">Principal's Name</p>
                        <p class="staff-comments-item">Prince Akpah, Tyonor Yiman</p>
                    </div>

                    <div class="principal-comments">
                        <p class="staff-comments-header">Principal's Comments</p>
                        <p class="staff-comments-item"> <?php 
                        echo $print->getHeadTeacherComment($studentid,$class,$term,$session,$schoolid);
                        ?></p>
                    </div>

                    <div class="principal-sign">
                        <p class="staff-comments-header">Principals's Signature</p>
                        <p class="staff-comments-item">.........................................</p>
                    </div>
        
        </div>
      <!-- end principal comments container -->


        <div class="item-container">
            <h6 class="grading-header">Key To Grading</h6>
            <div class="grading-items"><h6>A-Distinction</h6><span>75% Above</span></div>
            <div class="grading-items"><h6>B-Very Goood</h6><span>65-74</span></div>
            <div class="grading-items"><h6>C-Good</h6><span>55-64</span></div>
            <div class="grading-items"><h6>D-Fair</h6><span>40-54</span></div>
            <div class="grading-items"><h6>E-Poor</h6><span>39 Below</span></div> 
        </div>


           

</div>
<!-- End main result container -->


<!-- Begin main rating -->
<div class="main-rating-container">
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
    
      
<div>
<!-- End main rating -->


</div>
</body>

</html>