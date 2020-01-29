<?php
	include "../php/User.php";
	
	$User = new User();

	$email = $_GET['id'];
	$password = $_GET['pass'];
	$address1 = $_GET['ad1'];
	$address2 = $_GET['ad2'];
	$address3 = $_GET['ad3'];
	$telephone = $_GET['tel'];
	$firstname = $_GET['fir'];
	$lastname = $_GET['sur'];
	$age = $_GET['age'];
	//This creates a new user in the database
	$address = $address1 . "#" . $address2 . "#" . $address3;
	$passwordHash = password_hash($password, PASSWORD_DEFAULT);
	$replyToUserCreation = $User->createUser($firstname, $lastname, $passwordHash, $email, $address, $telphone, $age);
	
	echo json_encode($replyToUserCreation);
?>
