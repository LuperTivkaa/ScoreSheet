<?php
session_start();
if (!$_SESSION['user_info'] || empty($_SESSION['user_info']) || $_SESSION['user_info'] == "") 
   { 
    header("location:../../index.php");
    exit();
   }
  else {
    }
//ob_end_flush();
 ?>
