 <div class="secondary-nav">
            <div class="secondary-nav-content">
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
                $clientid = $_SESSION['user_info'][4];
                $client->schHeader($clientid);
                ?>
            </div>
        </div>