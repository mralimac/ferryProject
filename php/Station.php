<?php require_once 'Database.php'; ?>
<?php
class Station extends Database{
	
	//Returns a list of all stations
	function getAllStations(){
		
		$result = $this->query("SELECT * FROM in14004614.stations");
		$rows = array();
		
		while($row = mysqli_fetch_assoc($result)){
			array_push($rows, array("stationid"=>$row['stationid'],"stopname"=>$row['stop_name'], "stoplocation"=>$row['stop_location']));
		}
		return $rows;
	}
	
	
	//Adds a station to the database
	function addStation($stationName, $stationLoc){
		$result = $this->query("INSERT INTO stations VALUES(0, '$stationName', '$stationLoc')");
		if($result){
			return true;
		}else{
			return false;
		}
	}
}
?>