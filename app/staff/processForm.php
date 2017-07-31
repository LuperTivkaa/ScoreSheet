<?php
//session_start();
include 'inc/regSession.php';

//function to generate unique number below
//Autoload classes
include'inc/autoload.php';
$pay = new appForm();
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
$regno = $_SESSION['ID'];
$sn = filter_input(INPUT_POST, "sn", FILTER_SANITIZE_STRING);
$fn = filter_input(INPUT_POST, "fn", FILTER_SANITIZE_STRING);
$sex = filter_input(INPUT_POST, "sex", FILTER_SANITIZE_STRING);
$dob = filter_input(INPUT_POST, "dob", FILTER_SANITIZE_STRING);
$status = filter_input(INPUT_POST, "status", FILTER_SANITIZE_STRING);
$nation = filter_input(INPUT_POST, "nation", FILTER_SANITIZE_STRING);
$state = filter_input(INPUT_POST, "state", FILTER_SANITIZE_STRING);
$lga= filter_input(INPUT_POST, "lga", FILTER_SANITIZE_STRING);
$religion= filter_input(INPUT_POST, "rel", FILTER_SANITIZE_STRING);
$course= filter_input(INPUT_POST, "course", FILTER_SANITIZE_STRING);
$town = filter_input(INPUT_POST, "town", FILTER_SANITIZE_STRING);
$residentadd = filter_input(INPUT_POST, "resident", FILTER_SANITIZE_STRING);
$padd = filter_input(INPUT_POST, "padd", FILTER_SANITIZE_STRING);
$mail = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL);
$guardian = filter_input(INPUT_POST, "guardian", FILTER_SANITIZE_STRING);
$gmobile = filter_input(INPUT_POST, "gmobile", FILTER_SANITIZE_NUMBER_INT);
$gadd= filter_input(INPUT_POST, "gadd", FILTER_SANITIZE_STRING);
$goccup= filter_input(INPUT_POST, "goccup", FILTER_SANITIZE_STRING);
$sname = filter_input(INPUT_POST, "sname", FILTER_SANITIZE_STRING);
$sadd = filter_input(INPUT_POST, "sadd", FILTER_SANITIZE_STRING);
$mobile = filter_input(INPUT_POST, "mobile", FILTER_SANITIZE_NUMBER_INT);

 
$pay->setUserAdd($padd);
$perm_add = $pay->getUserAdd();

$pay->setUserAdd($town);
$town = $pay->getUserAdd();
    
$pay->setPhone($gmobile);
$g_phone = $pay->getPhone();    
    
$pay->setUserAdd($gadd);
$g_add = $pay->getUserAdd();
    
$pay->setUserAdd($sadd);
$s_add = $pay->getUserAdd();
    
$pay->setUserAdd($residentadd);
$corr_add = $pay->getUserAdd();
    
$pay->setOccup($goccup);
$g_occup = $pay->getOccup();

$pay->setReligion($religion);
$rel = $pay->getReligion();
    
$pay->setMail($mail);
$mail = $pay->getMail();
    
$pay->setCourse($course);
$course = $pay->getCourse();
    
$pay->setPhone($mobile);
$studmobile = $pay->getPhone();
    
$pay->setSex($sex);
$sex = $pay->getSex();
    
$pay->setDob($dob);
$dob = $pay->getDob();
    
$pay->setSurn($sn);
$sn = $pay->getSurn();
    
$pay->setLastname($fn);
$fn = $pay->getLastname();

$pay->setLastname($guardian);
$guardian = $pay->getLastname();
    
$pay->setLastname($sname);
$sname = $pay->getLastname();
    
$pay->setMaritalStatus($status);
$status = $pay->getMaritalStatus();
    
$pay->setNation($nation);
$nation = $pay->getNation();

$pay->setState($state);
$state = $pay->getState();
    
$pay->setLga($lga);
$lga = $pay->getLga();


$pay->submitForm($regno,$sn,$fn,$sex,$dob,$nation,$state,$lga,$rel,$status,$course,$town,$corr_add,$perm_add,$mail,$studmobile,$guardian,$g_add,$g_phone,$g_occup,$sname,$s_add);
    
}
else
{
    echo "Please submit a record";
}
?>