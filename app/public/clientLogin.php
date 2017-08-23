<?php
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\signUp;
//use \PDO;
$dbConnection = new dbConnection();
$client = new client($dbConnection);
$signup = new signUp($dbConnection);

if ($_SERVER["REQUEST_METHOD"]=="POST")
{

$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);



$signup->setMail($email);
$email = $signup->getMail();

$signup->setPassword($password);
$password = $signup->getPassword();



$signup->client_login($email,$password);
    
}
else
{
    echo "Please submit a record";
}