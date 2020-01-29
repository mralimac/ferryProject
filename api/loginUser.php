<?php
header("Access-Control-Allow-Origin: *");
require_once "../php/LoginHandler.php";
	
	$LoginHandler = new LoginHandler();

	$username = $_GET["u"];
	$password = $_GET["p"];	
	if($username == null){		
		$username = $_POST["u"];
		$password = $_POST["p"];
	}
	
	$result = $LoginHandler->login($username, $password);
	echo $result;
?>