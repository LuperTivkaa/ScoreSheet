<?php

//including classes
include 'inc/autoload.php';

$myClient = new student();

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
// $app->setPin($id);
// $did = $app->getPin();
$myClient->loadStates($id);
}
else
{
echo "Please send some data";    
}

?>
