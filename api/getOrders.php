<?php
header("Access-Control-Allow-Origin: *");
require_once "../php/Ferry.php";
	
	$Ferry = new Ferry();
	
	
	$result = $Ferry->getAllFerriesMobile();
	echo $result;
?>