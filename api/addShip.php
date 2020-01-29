<?php
include "../php/Ship.php";
	
	$Ship = new Ship();

	$shipName = $_GET["name"];
	$shipCap = $_GET["cap"];
	
	$result = $Ship->addShip($shipName, $shipCap);
		
	if($result != null){
		echo json_encode($result);
	}
?>