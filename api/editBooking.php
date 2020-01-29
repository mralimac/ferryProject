<?php
	require_once "../php/Ferry.php";
	
	$Ferry = new Ferry();
	
	$orderID = $_GET["id"];
	$type = $_GET["type"];
	$value = $_GET["value"];
	
	
	if($type == "adultSeats"){
		$type = "numberOfAdultSeats";
	}
	
	if($type == "childSeats"){
		$type = "numberOfChildSeats";
	}
	
	
	$result = $Ferry->editBooking($orderID, $type, $value);
	if($result){
		echo $result;
	}
	
?>
