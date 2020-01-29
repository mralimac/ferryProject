<?php
header("Access-Control-Allow-Origin: *");
require_once "../php/Ferry.php";
	
	$Ferry = new Ferry();
	
	$orderID = $_GET["o"];
	
	$result = $Ferry->getFerryMobile($orderID);
	echo $result;
?>