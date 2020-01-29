<?php
header("Access-Control-Allow-Origin: *");
require_once "../php/Ferry.php";
	
	$Ferry = new Ferry();
	
	$userid = $_GET["u"];
	
	
	$result = $Ferry->getOrderByUserIDMobile($userid);
	echo $result;
?>