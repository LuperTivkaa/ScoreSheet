<?php
include 'inc/regSession.php';

//function to generate unique number below
//Autoload classes
include'inc/autoload.php';
$clientid = $_SESSION['user_info'][4];
$user_id = $_SESSION['user_info'][0];
$client = new client();
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
$priority = filter_input(INPUT_POST, "priorrity", FILTER_SANITIZE_STRING);
$notes = filter_input(INPUT_POST, "notes", FILTER_SANITIZE_STRING);

//$status ='true';

$client->setPriority($priority);
$priority = $client->getPriority();


$client->setNotes($notes);
$notes = $client->getPriority();

$todayDate = date("Y-m-d");

$client->myTicket($clientid,$title,$priority,$notes,$todayDate,$user_id);
    
}
else
{
    echo "Please submit a record";
}