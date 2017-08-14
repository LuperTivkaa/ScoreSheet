<?php
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\signUp;
// $base = new base();
// $base->Test();
$dbConnection = new dbConnection();
$login = new signUp($dbConnection);

if ($_SERVER["REQUEST_METHOD"]=="POST")
{

$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

$login->setMail($email);
$email = $login->getMail();

$login->setPassword($password);
$password = $login->getPassword();

$login->user_login($email,$password);
    
}
else
{
    echo "Please submit a record";
}