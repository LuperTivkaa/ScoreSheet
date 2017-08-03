<?php
require '../../vendor/autoload.php';
require_once '../../vendor/fzaninotto/Faker/src/autoload.php';

use ScoreSheet\signUp;

$myClient = new signUp();

if ($_SERVER["REQUEST_METHOD"]=="POST")
{

//$regno = $_SESSION['ID'];
$user_name = filter_input(INPUT_POST, "user_name", FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

$myClient->setUserName($user_name);
$username = $myClient->getUserName();

$myClient->setMail($email);
$email = $myClient->getMail();

$myClient->setPassword($password);
$password = $myClient->getPassword();



$myClient->newClient($username,$email,$password);
    
}
else
{
    echo "Please submit a record";
}