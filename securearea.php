<?php
	require_once "php/LoginHandler.php";
	//Checks if user is logged in
	$loginHandler = new LoginHandler();
	$isUserLoggedIn = $loginHandler->isLoggedIn();
	if($currentUser["userID"] == null){
		header("Location: login.php");
		die();
	}
?>