<?php
	require_once "php/LoginHandler.php";
	//Checks if user is logged in
	$loginHandler = new LoginHandler();
	$isUserLoggedIn = $loginHandler->isLoggedIn();
	if($currentUser["is_admin"] != 1){
		header("Location: index.php");
		die();
	}
?>