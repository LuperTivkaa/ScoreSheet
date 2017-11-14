<?php
session_start();
require '../../vendor/autoload.php';
//require_once '../../vendor/fzaninotto/Faker/src/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\signUp;
//use \PDO;
$dbConnection = new dbConnection();
$client = new client($dbConnection);
$signup = new signUp($dbConnection);
$clientid = $_SESSION['sess_info'][0];
$dateCreated = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"]=="POST")
{

//$regno = $_SESSION['ID'];
$user_name = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, "pass", FILTER_SANITIZE_STRING);

$signup->setUserName($user_name);
$username = $signup->getUserName();

$signup->setMail($email);
$email = $signup->getMail();

$signup->setPassword($password);
$password = $signup->getPassword();
 if(empty($username) || empty($password) || empty($email))
        {
            exit("Please fill all the fields...");
        }else{
            //CALL METHOD TO ADD CA
$signup->client_root($clientid,$email,$username,$password,$dateCreated,$dateCreated);
        }
    
}
else
{
    echo "Please submit a record";
}