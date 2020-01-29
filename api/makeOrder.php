<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<?php
include "../php/Ferry.php";
	
	$Ferry = new Ferry();
	
	$orderid = $_GET['o'];
	$tripid = $_GET['trip'];
	$userid = $_GET['user'];
	$adultSeats = $_GET['adult'];
	$childSeats = $_GET['child'];
	$hasDisabled = $_GET['dis'];
	
	if($orderid = "mobile"){
		$orderid = md5(rand());
	}
	
	$result = $Ferry->makeOrder($orderid, $userid, $tripid, $adultSeats, $childSeats, $hasDisabled);
	
	if($result != null){
		echo json_encode($result);
	}
	
	
	
	

?>