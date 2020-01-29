<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
require_once "../php/LoginHandler.php";
	
	$LoginHandler = new LoginHandler();

	$cookieID = $_GET["c"];
	
	
	
	$result = $LoginHandler->getUserBasedOnCookie($cookieID);
	echo $result;
?>