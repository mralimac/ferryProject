<?php
include "../php/User.php";
	
	$User = new User();

	$firstname = $_GET['firstname'];
	$lastname = $_GET['lastname'];
	$password = $_GET['password'];
	$confirmpassword = $_GET['confirmpassword'];
	$email = $_GET['email'];
	$address = $_GET['address'];
	$telphone = $_GET['telphone'];
	$age = $_GET['age'];
	
	if($password == $confirmpassword){
		$passwordHash = password_hash($password);
		$result = $User->createUser($firstname, $lastname, $passwordhash, $email, $address, $telphone, $age);
		
		if($result != null){
			echo json_encode($result);
		}
	}
	
	
	
	
	

?>