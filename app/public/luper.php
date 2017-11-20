<?php 
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use Carbon\Carbon;
//use \PDO;


$dbConnection = new dbConnection();
$c = new client($dbConnection);
$d = new student($dbConnection);
// $user->setID(1);
// $ID= $user->getID();
//$user->printName($name);

//$dbConnection->testDbConn();

//$user->user_login('lupertivkaa@gmail.com','manex');
$d->TestStudent();
//$d->loadClassArm();
$tomorrow = Carbon::now()->subMinutes(3)->diffForHumans();
echo $tomorrow;