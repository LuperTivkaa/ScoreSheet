
<?php
//database file credentialsfor school software
//$dsn = 'mysql:host=localhost;dbname=facile';
//$username = 'schoolInfo';
//$password = '2017**_';
//

$dsn = 'mysql:host=localhost;dbname=smarty';
$username = 'smarty_ems_2017';
$password = '*enterprise_ems';

try{

$db = new PDO($dsn, $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
//echo "Unable to connect the databse at the moment";
echo $e->getMessage();
exit();
}
?>
