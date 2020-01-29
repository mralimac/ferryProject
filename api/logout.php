<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../php/LoginHandler.php";
	
	$LoginHandler = new LoginHandler();
	
	$userID = $_GET['id'];
	$userType = $_GET['type'];
	
	if($userType == "single"){
		$resultOfLogout = $LoginHandler->logoutSession();
	}else{
		$resultOfLogout = $LoginHandler->logoutAll($userID);
	}
	
	
	if($resultOfLogout == null){
		echo json_encode(array("result" => false));
	}else{
		echo json_encode(array("result" => true));
	}
?>