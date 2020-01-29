<?php require_once 'Database.php'; ?>
<?php
class Ship extends Database{
	
	//Returns a list of all ships
	function getAllShips(){
		$result = $this->query("SELECT * FROM in14004614.ship");
		$rows = array();
		while($row = mysqli_fetch_assoc($result)){
			array_push($rows, array("shipid"=>$row['shipid'],"shipname"=>$row['ship_name'], "cap"=>$row['number_of_seats']));
		}
		return $rows;
	}
	
	//Adds a ship to the database
	function addShip($shipName, $shipCap){
		$result = $this->query("INSERT INTO ship VALUES(0, $shipCap, '$shipName')");
		if($result){
			return true;
		}else{
			return false;
		}
	}
}
?>