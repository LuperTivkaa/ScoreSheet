<?php
require '../../vendor/autoload.php';
//require_once '../../vendor/fzaninotto/Faker/src/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\signUp;
//use \PDO;
$dbConnection = new dbConnection();
$client = new client($dbConnection);
$signup = new signUp($dbConnection);

if ($_SERVER["REQUEST_METHOD"]=="POST")
{

//$regno = $_SESSION['ID'];
// $user_name = filter_input(INPUT_POST, "user_name", FILTER_SANITIZE_STRING);
// $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
// $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

$user_name = filter_input(INPUT_POST, "user", FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, "pass", FILTER_SANITIZE_STRING);

$signup->setUserName($user_name);
$username = $signup->getUserName();

$signup->setMail($email);
$email = $signup->getMail();

$signup->setPassword($password);
$password = $signup->getPassword();

$signup->newClient($username,$email,$password);
    
}
else
{
    echo "Please submit a record";
}