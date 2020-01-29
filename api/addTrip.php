<?php
include "../php/Ferry.php";
	
	$Ferry = new Ferry();

	$departTime = $_GET["dep"];
	$arrivalTime = $_GET["arr"];
	$timeInPort = $_GET["tip"];
	$srcStop = $_GET["src"];
	$dstStop = $_GET["dst"];
	$shipid = $_GET["ship"];
	
	$result = $Ferry->addTrip($departTime, $arrivalTime, $timeInPort, $srcStop, $dstStop, $shipid);
		
	if($result != null){
		echo json_encode($result);
	}
?>