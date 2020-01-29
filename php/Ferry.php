<?php require_once 'Database.php'; ?>
<?php


class Ferry extends Database{
	
	function removeBooking($orderID){
		$result = $this->query("DELETE FROM orderlist WHERE orderid = '$orderID'");
		if($result){
			return true;
		}else{
			return false;
		}
	}
	
	//This Function updates a booking details. One example of this is the own user's interface
	function editBooking($orderID, $type, $value){
		$result = $this->query("UPDATE orderlist SET $type = $value WHERE orderid = '$orderID'");
		if($result){
			return true;
		}else{
			return false;
		}
	}
	
	//This creates an order that the user wants
	function makeOrder($orderid, $userid, $tripid, $adultSeats, $childSeats, $hasDisabled){
		$result = $this->query("INSERT INTO orderlist VALUES('$orderid', $userid, $tripid, $adultSeats, $childSeats, $hasDisabled)");		
		if($result){
			$result= $this->query("UPDATE users SET number_of_trips = number_of_trips + 1 WHERE userid = $userid");
			return true;
		}else{
			return false;
		}
	}
	
	//Gets a relevant order based on OrderID
	function getOrderByOrderID($orderid){
		$result = $this->query("SELECT orderlist.orderid, orderlist.userid, orderlist.tripid, orderlist.numberOfAdultSeats, orderlist.numberOfChildSeats, orderlist.hasDisabled, trip1.arrival_time AS arrivalTime, trip1.departure_time AS departTime FROM orderlist
								INNER JOIN trips trip1 ON in14004614.orderlist.tripid = trip1.tripid
								WHERE orderid = '$orderid'");
		while($row = mysqli_fetch_assoc($result)){
			$rows = array("departTime" =>$row['departTime'], "arrivalTime" => $row["arrivalTime"], "orderid"=>$row['orderid'],"userid"=>$row['userid'], "tripid"=>$row['tripid'], "adultSeats"=>$row['numberOfAdultSeats'], "childSeats"=>$row['numberOfChildSeats'], "hasDisabled"=>$row['hasDisabled']);
		}
		return $rows;
	}
	
	//Returns a list of Orders based on the userID
	function getOrderByUserIDMobile($userid){
		$result = $this->query("SELECT orderlist.orderid, orderlist.userid, orderlist.tripid, orderlist.numberOfAdultSeats, orderlist.numberOfChildSeats, orderlist.hasDisabled, trip1.arrival_time AS arrivalTime, trip1.departure_time AS departTime FROM orderlist
								INNER JOIN trips trip1 ON in14004614.orderlist.tripid = trip1.tripid
								WHERE userid = $userid");
		$rows = array();
		$rows["orders"]=array();
		while($row = mysqli_fetch_assoc($result)){
			array_push($rows["orders"], array(	
							"departTime" =>$row['departTime'],
							"arrivalTime" => $row["arrivalTime"],
							"orderid"=>$row['orderid'],
							"userid"=>$row['userid'],
							"tripid"=>$row['tripid'],
							"adultSeats"=>$row['numberOfAdultSeats'],
							"childSeats"=>$row['numberOfChildSeats'],
							"hasDisabled"=>$row['hasDisabled']));
		}
		return json_encode($rows);
	}
	
	//Returns a list of Orders based on the userID
	function getOrderByUserID($userid){
		$result = $this->query("SELECT orderlist.orderid, orderlist.userid, orderlist.tripid, orderlist.numberOfAdultSeats, orderlist.numberOfChildSeats, orderlist.hasDisabled, trip1.arrival_time AS arrivalTime, trip1.departure_time AS departTime FROM orderlist
								INNER JOIN trips trip1 ON in14004614.orderlist.tripid = trip1.tripid
								WHERE userid = $userid");
		$rows = array();
		while($row = mysqli_fetch_assoc($result)){
			array_push($rows, array(	
							"departTime" =>$row['departTime'],
							"arrivalTime" => $row["arrivalTime"],
							"orderid"=>$row['orderid'],
							"userid"=>$row['userid'],
							"tripid"=>$row['tripid'],
							"adultSeats"=>$row['numberOfAdultSeats'],
							"childSeats"=>$row['numberOfChildSeats'],
							"hasDisabled"=>$row['hasDisabled']));
		}
		return $rows;
	}
	
	//Returns a list of Order based on the TripID
	function getOrderByTripID($tripd){
		$result = $this->query("SELECT * FROM orderlist WHERE tripid = $tripid");
		$rows = array();
		
		while($row = mysqli_fetch_assoc($result)){
			array_push($rows, array("orderid"=>$row['orderid'],"userid"=>$row['userid'], "tripid"=>$row['tripid'], "adultSeats"=>$row['numberOfAdultSeats'], "childSeats"=>$row['numberOfChildSeats'], "hasDisabled"=>$row['hasDisabled']));
		}
		return $rows;
	}
	
	//Gets a Ferry based on the Ferry ID
	function getFerryMobile($ferryID){
		$result = $this->query("SELECT (ship1.number_of_seats - (SELECT SUM(orderlist.numberOfAdultSeats) + SUM(orderlist.numberOfChildSeats) FROM orderlist WHERE tripid = $ferryID)) AS seatsLeft, ship1.number_of_seats AS shipSeats, trips.departure_time, trips.arrival_time, trips.time_in_port, trips.has_disabled, ship1.number_of_seats AS shipCap, ship1.ship_name AS shipname, station1.stop_name AS srcStopName, station1.stop_location AS srcStopLoc, station2.stop_name AS dstStopName, station2.stop_location AS dstStopLoc
			FROM in14004614.trips
			INNER JOIN ship ship1 ON in14004614.trips.shipid = ship1.shipid
			INNER JOIN stations station1 ON trips.src_stop = station1.stationid 
			INNER JOIN stations station2 ON trips.dst_stop = station2.stationid
			WHERE tripid = $ferryID
			LIMIT 1
		");
		$rows = array();
		
		
		
		while($row = mysqli_fetch_assoc($result)){
			if($row['seatsLeft'] == null){
				$row['seatsLeft'] = $row['shipSeats'];
			}
			
			
			$rows = array("departureTime" => $row['departure_time'],			
			"arrivalTime" => $row['arrival_time'],
			"timeInPort" => $row['time_in_port'],
			"hasDisabled" => $row['has_disabled'],
			"shipCap" => $row['shipCap'],
			"shipName" => $row['shipname'],
			"srcStopName" => $row['srcStopName'],
			"srcStopLoc" => $row['srcStopLoc'],
			"dstStopName" => $row['dstStopName'],
			"dstStopLoc" => $row['dstStopLoc'],
			"seatsLeft" => $row['seatsLeft']
			);
		}
		return json_encode($rows);
	}
	
	
	//Gets a Ferry based on the Ferry ID
	function getFerry($ferryID){
		$result = $this->query("SELECT (ship1.number_of_seats - (SELECT SUM(orderlist.numberOfAdultSeats) + SUM(orderlist.numberOfChildSeats) FROM orderlist WHERE tripid = $ferryID)) AS seatsLeft, trips.departure_time, trips.arrival_time, trips.time_in_port, trips.has_disabled, ship1.number_of_seats AS shipCap, ship1.ship_name AS shipname, station1.stop_name AS srcStopName, station1.stop_location AS srcStopLoc, station2.stop_name AS dstStopName, station2.stop_location AS dstStopLoc
			FROM in14004614.trips
			INNER JOIN ship ship1 ON in14004614.trips.shipid = ship1.shipid
			INNER JOIN stations station1 ON trips.src_stop = station1.stationid 
			INNER JOIN stations station2 ON trips.dst_stop = station2.stationid
			WHERE tripid = $ferryID
			LIMIT 1
		");
		$rows = array();
		while($row = mysqli_fetch_assoc($result)){
			$rows = array("departureTime" => $row['departure_time'],			
			"arrivalTime" => $row['arrival_time'],
			"timeInPort" => $row['time_in_port'],
			"hasDisabled" => $row['has_disabled'],
			"shipCap" => $row['shipCap'],
			"shipName" => $row['shipname'],
			"srcStopName" => $row['srcStopName'],
			"srcStopLoc" => $row['srcStopLoc'],
			"dstStopName" => $row['dstStopName'],
			"dstStopLoc" => $row['dstStopLoc'],
			"seatsLeft" => $row['seatsLeft']
			);
		}
		return $rows;
	}
	
	//Gets the list of ferries between two dates. This is not fully functional
	function getFerriesBetweenThisTwoDates($timeOne, $timeTwo){
		$result = $this->query("SELECT * FROM trips WHERE departure_time => '$timeOne' AND departure_time < '$timeTwo'");
		$rows = array();
		
		while($row = mysqli_fetch_assoc($result)){
			array_push($rows, array("tripid"=>$row['tripid'],"departTime"=>$row['departure_time'], "arrivalTime"=>$row['arrival_time'], "timeInPort"=>$row['time_in_port'], "srcStop"=>$row['src_stop'], "dstStop"=>$row['dst_stop'], "createdAt"=>$row['created_at'], "hasDisabled"=>$row['has_disabled'], "shipid"=>$row['shipid'], "isCancelled"=>$row['is_cancelled']));
		}
		return $rows;
	}
	
	//Returns a list of all ferries
	function getAllFerries(){
		$result = $this->query("SELECT trips.tripid, trips.departure_time, trips.arrival_time, trips.time_in_port, trips.src_stop, trips.dst_stop, trips.created_at, trips.has_disabled, trips.shipid, trips.is_cancelled, station1.stop_name AS srcStopName, station1.stop_location AS srcStopLoc, station2.stop_name AS dstStopName, station2.stop_location AS dstStopLoc
								FROM trips
								INNER JOIN stations station1 ON trips.src_stop = station1.stationid
								INNER JOIN stations station2 ON trips.dst_stop = station2.stationid");
		$rows = array();
		
		while($row = mysqli_fetch_assoc($result)){
			array_push($rows, array("tripid"=>$row['tripid'],
									"departTime"=>$row['departure_time'],
									"arrivalTime"=>$row['arrival_time'],
									"timeInPort"=>$row['time_in_port'],
									"srcStop"=>$row['src_stop'],
									"dstStop"=>$row['dst_stop'], 
									"createdAt"=>$row['created_at'],
									"hasDisabled"=>$row['has_disabled'],
									"shipid"=>$row['shipid'],
									"isCancelled"=>$row['is_cancelled'],
									"srcStopName"=>$row['srcStopName'],
									"srcStopLoc"=>$row['srcStopLoc'],
									"dstStopName"=>$row['dstStopName'],
									"dstStopLoc"=>$row['dstStopLoc']
									));
		}
		return $rows;
	}
	
	function getAllFerriesMobile(){
		$result = $this->query("SELECT trips.tripid, trips.departure_time, trips.arrival_time, trips.time_in_port, trips.src_stop, trips.dst_stop, trips.created_at, trips.has_disabled, trips.shipid, trips.is_cancelled, station1.stop_name AS srcStopName, station1.stop_location AS srcStopLoc, station2.stop_name AS dstStopName, station2.stop_location AS dstStopLoc
						FROM trips
						INNER JOIN stations station1 ON trips.src_stop = station1.stationid
						INNER JOIN stations station2 ON trips.dst_stop = station2.stationid");
		$rows = array();
		$rows["orders"]=array();
		while($row = mysqli_fetch_assoc($result)){
			array_push($rows["orders"], array("tripid"=>$row['tripid'],
									"departTime"=>$row['departure_time'],
									"arrivalTime"=>$row['arrival_time'],
									"timeInPort"=>$row['time_in_port'],
									"srcStop"=>$row['src_stop'],
									"dstStop"=>$row['dst_stop'], 
									"createdAt"=>$row['created_at'],
									"hasDisabled"=>$row['has_disabled'],
									"shipid"=>$row['shipid'],
									"isCancelled"=>$row['is_cancelled'],
									"srcStopName"=>$row['srcStopName'],
									"srcStopLoc"=>$row['srcStopLoc'],
									"dstStopName"=>$row['dstStopName'],
									"dstStopLoc"=>$row['dstStopLoc']
									));
		}
		return json_encode($rows);
	}
	
	//Adds a ferry trip. this is usually through the admin interface
	function addTrip($departTime, $arrivalTime, $timeInPort, $srcStop, $dstStop, $shipid){
		$result = $this->query("INSERT INTO trips VALUES(0, '$departTime', '$arrivalTime', '$timeInPort', $srcStop, $dstStop, NOW(), 0, $shipid, 0)");
		if($result){
			return true;
		}else{
			return false;
		}
	}
}
?>