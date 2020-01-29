<?php
	require_once "../php/Ferry.php";
	
	$Ferry = new Ferry();
	
	$orderID = $_GET["id"];
	
	$result = $Ferry->removeBooking($orderID);
	
	echo $result;
?>