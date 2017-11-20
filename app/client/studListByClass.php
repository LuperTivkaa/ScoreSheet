<?php
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
use Carbon\Carbon;
//use \PDO;
$dbConnection = new dbConnection();
$client = new client($dbConnection);
$student = new student($dbConnection);
$staff = new staff($dbConnection);

$clientid = $_SESSION['user_info'][4];
$userid = $_SESSION['user_info'][0];
$roleid = $_SESSION['user_info'][2];
$staff->clientUser($roleid,$clientid);
?>


 <!-- Skills content div  -->

                  <div class="intro-content">
                  <!--conatiner  -->
                        <div class="container">

                            <div  class="row">

                                <div class="col-md-6">
                                <h6 class="top-header"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>  Student List By Class</h6>

                                    <div class="row">

                                        
                                            <!--text input  -->
                                            <div class="form-group col-md-12">
                                                <!-- <label for="affective-skills-item">Affe/label> -->
                                                <label for="studListclass">Class:</label>
                                                <select class="custom-select form-control" id="studListclass" name="studListclass">
                                                <?php
                                                $client->loadClass($clientid);
                                                ?>
                                                </select> 
                                            </div>

                                            <div class="form-group col-md-12">
                                                <!-- <label for="lastname">Last Name:</label> -->
                                                <label for="studsession">Session:</label>
                                                <select class="custom-select form-control" id="studsession" name="studsession">
                                                <?php
                                                $client->loadSession($clientid);
                                                ?>
                                                </select> 
                                            </div>
                                        
                                            <!--button  -->
                                            <div class="form-group col-md-6">
                                                <button class="submit btn btn-primary mb-3"  id="studByClassBtn">List Student(s)</button>
                                            </div>
                                            <div class="form-group col-md-6">
                                            </div>
                                        
                                    
                                    </div>

                                </div>

                                <div class="col-md-6">
                               
                                    <div class="row">

                                        
                                            <!--text input  -->
                                            
                                            <!--button  -->
                                            <div class="form-group col-md-6">
                                            </div>
                                            
                                        
                                    
                                    </div>

                                </div>

                            </div>

                            <!--content row begins  -->
                            <div class="row">
                                <div class="col-md-10" id="st-list">
                                
                                </div>

                                <div class="col-md-2">

                                </div>

                            </div>
                            <!--content row ends  -->

                        </div>
                        <!--end container  -->
                  </div>
                  <!-- End Skills content div  -->
              <!-- create fee items -->
              