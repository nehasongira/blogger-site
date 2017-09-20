<?php
//include config
require_once('connnection.php');

//log user out
$mysql_user->logout();
header('Location: index.php'); 

?>