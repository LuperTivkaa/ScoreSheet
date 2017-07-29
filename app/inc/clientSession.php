<?php
ob_start(); 
session_start();
if (!($_SESSION['sess_info'] ) || ($_SESSION['sess_info']  == "")) 
{ 
header("location:../index.php");
exit(); 
}
else
{}
ob_end_flush();
 ?>
