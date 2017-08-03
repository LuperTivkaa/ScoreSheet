<?php
require '../../vendor/autoload.php';
use ScoreSheet\signUp;

$login = new signUp();

if ($_SERVER["REQUEST_METHOD"]=="POST")
{

$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);



$login->setMail($email);
$email = $login->getMail();

$login->setPassword($password);
$password = $login->getPassword();



$login->client_login($email,$password);
    
}
else
{
    echo "Please submit a record";
}