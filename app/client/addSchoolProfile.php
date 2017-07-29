<?php
//session_start();
include 'inc/regSession.php';
$clientid = $_SESSION['sess_info'][0];
//function to generate unique number below
//Autoload classes
include'inc/autoload.php';
$client = new client();
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
//$regno = $_SESSION['ID'];
$sch_name = filter_input(INPUT_POST, "inst_name", FILTER_SANITIZE_STRING);
$sch_category = filter_input(INPUT_POST, "inst_category", FILTER_SANITIZE_STRING);
$nation = filter_input(INPUT_POST, "nation", FILTER_SANITIZE_STRING);
$state = filter_input(INPUT_POST, "state", FILTER_SANITIZE_STRING);
$lg = filter_input(INPUT_POST, "lg", FILTER_SANITIZE_STRING);
$city = filter_input(INPUT_POST, "city", FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING);
$mobile = filter_input(INPUT_POST, "mobile", FILTER_SANITIZE_STRING);

$client->setSchName($sch_name);
$schname = $client->getSchName();

$client->setSchType($sch_category);
$schtype = $client->getSchType();

$client->setCountry($nation);
$country = $client->getCountry();

$client->setState($state);
$state = $client->getState();

$client->setLga($lg);
$lga = $client->getLga();

$client->setCity($city);
$city = $client->getCity();

$client->setAddress($address);
$address = $client->getAddress();

$client->setMobile($mobile);
$mobile = $client->getMobile();

$client->instProfile($schname,$schtype,$clientid,$country,$state,$lga,$city,$address,$mobile);
    
}
else
{
    echo "Please submit a record";
}