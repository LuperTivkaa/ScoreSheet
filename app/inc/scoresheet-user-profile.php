<div class="primary-nav">

            <div class="primary-nav-content">
                <h2 class="site-name">ScoreSheet</h2>
                <ul class="primary-link">
                    <li>
                        <?php echo $_SESSION['user_info'][1];?>
                    </li>
                    <li>
                    <?php
                    if ($_SESSION['user_info'][2] == 3)
                    {
                        echo '<a href="../admin/index.php"><i class="fa fa-user-circle-o fa-fw" aria-hidden="true"></i> Admin</a>';
                    }
                        ?>

                    </li>
                    <li>
                        <a href="./logout.php"><i class="fa fa-lock fa-fw" aria-hidden="true"></i> Log Out </a
                    </li>
                </ul>
            </div>

        </div>