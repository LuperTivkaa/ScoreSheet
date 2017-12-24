 <div class="secondary-col">
                
                <?php
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
                //$manager = new manager($dbConnection);
                $clientid = $_SESSION['user_info'][4];
                $staffid = $_SESSION['user_info'][0];
                $client->currentSchoolSettings($clientid);
                 ?>

                
                <?php 
                $client->studentInClass($staffid,$clientid);
                ?>

                <?php 
                $client->ClassSummaryCount($staffid,$clientid);
                ?>

                <div class="class-student-list">
                <!-- Display student on selection of class-->

                </div>
                

                <!-- <div class="my-staff-list">
                

                </div> -->
                <!-- <div class="best-wishes"> -->
                    <!-- Display students with birthdayon a particular day or next -->
                    <!-- <h2 class="headings">Staff List</h2>
                    <p>How many best wishes to do we have</p>
                    <p>There are quite a number of students on this list</p>
                    <p>We have to send bithday wishes</p> -->
<!-- 
                </div> -->
            </div>