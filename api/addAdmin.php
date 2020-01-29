<?php
include "../php/User.php";
	
	$user = new User();

	$userid = $_GET['id'];
	
	$result = $user->makeUserAdmin($userid);
	
	if($result != null){
		echo json_encode($result);
	}

?>