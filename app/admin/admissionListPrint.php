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

$class = filter_input(INPUT_GET, "class", FILTER_SANITIZE_NUMBER_INT);
$session = filter_input(INPUT_GET, "session", FILTER_SANITIZE_NUMBER_INT);
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
    <title>ScoreSheet | Admission List </title>
    <?php include '../inc/scoresheet-header.php';
    
$schid = $_SESSION['user_info'][4];
//$newStaff = new student();
$staffid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->adminUser($myroleid,$schid);
    ?>

<body>

<div class="result-content-wrapper">

    <div class="school-profile">
                    <?php
                    $staff->schoolAvatar($schid);
                    ?>
        <?php
        $print->schoolProfileHeader($schoolid);
        ?>
    </div>
    <!--end school profile div  -->
    
    <div class="result-details">
        <?php
            $client->admissionListPrint($class,$session,$schoolid);
        ?>
    </div>

    

</div>

</body>

</html>