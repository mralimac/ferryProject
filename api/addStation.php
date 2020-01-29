<?php
include "../php/Station.php";
	
	$Station = new Station();

	$stationName = $_GET["name"];
	$stationLocation = $_GET["loc"];
	
	$result = $Station->addStation($stationName, $stationLocation);
		
	if($result != null){
		echo json_encode($result);
	}
?>