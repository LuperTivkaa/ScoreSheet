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
$schid = $_SESSION['user_info'][4];
$staffid = $_SESSION['user_info'][0];
?>

<div class="primary-nav">

            <div class="primary-nav-content">
                <h2 class="site-name">ScoreSheet</h2>
                <ul class="primary-link">
                    <li>
                        <?php 
                        if($_SESSION['user_info'][2] != 3)
                        {
                          $client->staffIconName($schid,$staffid);
                        }
                        else{
                            echo $_SESSION['user_info'][1];
                        }
                        ?>
                        <span><a href="./logout.php"><i class="fa fa-lock fa-fw" aria-hidden="true"></i> Log Out </a></span>
                    </li>
                    <li>
                    <?php
                        if ($_SESSION['user_info'][2] == 3)
                        {
                            echo '<a href="../admin/index.php"><i class="fa fa-user-circle-o fa-fw" aria-hidden="true"></i> Admin</a>';
                        }
                    ?>

                    </li>
                   
                </ul>
            </div>

        </div>