<?php
//session_start();

/// CREATE TICKETS BASED ON CLIENTS
include 'inc/regSession.php';
$clientid = $_SESSION['sess_info'][0];
//function to generate unique number below
//Autoload classes
include'inc/autoload.php';
$client = new client();
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
$priority = filter_input(INPUT_POST, "priorrity", FILTER_SANITIZE_STRING);
$notes = filter_input(INPUT_POST, "notes", FILTER_SANITIZE_STRING);


$client->setNotes($title);
$title = $client->getNotes();

$client->setPriority($priority);
$priority = $client->getPriority();


$client->setNotes($notes);
$notes = $client->getNotes();

$todayDate = date("Y-m-d");

$client->myTicket($clientid,$title,$priority,$notes,$todayDate,$clientid);
    
}
else
{
    echo "Please submit a record";
}