<?php

//class autolad
include 'inc/autoload.php';

$signIn = new login();
if ($_SERVER["REQUEST_METHOD"]=="POST")
{

$pin = filter_input(INPUT_POST, "pin", FILTER_SANITIZE_NUMBER_INT);
$reg = filter_input(INPUT_POST, "reg", FILTER_SANITIZE_STRING);

$signIn->setPin($pin);
$pin = $signIn->getPin();
    
$signIn->setReg($reg);
$reg = $signIn->getReg();
    
$signIn->newAppLogin($pin,$reg);
//$signIn->userSession($reg);

}
else
{
    echo "Submit a record!";
}

?>