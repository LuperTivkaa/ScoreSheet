<?php
ob_start(); 
session_start();
if ($_SESSION['user_info'][2] == "3" || $_SESSION['user_info'][2] == "4" || $_SESSION['user_info'] != "") 
{ 

}
else
{
header("location:../../index.php");
exit(); 
//echo ($_SESSION['user_info'][2]);
}
ob_end_flush();
 ?>
