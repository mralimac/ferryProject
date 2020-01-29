<?php include 'header.php'; ?>
<?php require_once "php/User.php"; ?>
<?php require_once "php/Ship.php"; ?>
<?php require_once "php/Station.php"; ?>
<?php require_once "php/Ferry.php"; ?>
<?php require_once 'securearea.php'; ?>
<?php require_once 'adminzone.php'; ?>
<div class="container">
	<div class="row">
		<div class="col">
			<h2>Add new admin</h2>
			<div class="form-group">
				<label>Pick User</label>
				<select class="form-control" id="selectAdmin" required>
				<?php
						$User = new User();
						$allUsers = $User->getAllUsers();				
						for($i = 0; $i < count($allUsers); $i++){
							if($allUsers[$i]["is_admin"] == false){
								//Insert Station Options
								?><option value="<?php echo $allUsers[$i]['userid']; ?>"><?php echo $allUsers[$i]['firstname'] . " " . $allUsers[$i]['lastname']; ?></option>
							<?php } ?>
						<?php
						}
					?>				
				</select>
				<button id="addAdminBtn" class="btn btn-primary">Make Admin</button>
			</div>
		</div>
		<div class="col">
			<h2>Add new station</h2>
			<div class="form-group">
				<label>Station Name</label>
				<input class="form-control" type="text" id="stationNameInput" required>
				<label>Station Location</label>
				<input class="form-control" type="text" id="stationLocationInput" required>
				<button id="addStationBtn" class="btn btn-primary">Add Station</button>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<h2>Add new ship</h2>
			<div class="form-group">
				<label>Ship Name</label>
				<input class="form-control" type="text" id="shipNameInput" required>
				<label>Ship Capacity</label>
				<input class="form-control" type="text" id="shipCapacityInput" required>
				<button id="addShipBtn" class="btn btn-primary">Add Ship</button>
			</div>
		</div>
		<div class="col">
			<h2>Add new trip</h2>
			<div class="form-group">
				<label>Departure Time</label>
				<input class="form-control" type="date" id="departDateInput" required>
				<input class="form-control" type="time" id="departTimeInput" required>
				<label>Arrival Time</label>
				<input class="form-control" type="date" id="arrivalDateInput" required>
				<input class="form-control" type="time" id="arrivalTimeInput" required>
				<label>Time in Port</label>
				<input class="form-control" type="int" id="timeInPortInput" required>
				<label>Select Departure Port</label>
				<select class="form-control" id="departPortSelected">
				<?php
						$Station = new Station();
						$stationOptions = $Station->getAllStations();				
						for($i = 0; $i < count($stationOptions); $i++){
							//Insert Station Options
							?><option value="<?php echo $stationOptions[$i]['stationid']; ?>"><?php echo $stationOptions[$i]['stopname']; ?></option>
						<?php
						}
					?>
				</select>
				<label>Select Arrival Port</label>
				<select class="form-control" id="arrivalPortSelected">
				<?php
						$Station = new Station();
						$stationOptions = $Station->getAllStations();				
						for($i = 0; $i < count($stationOptions); $i++){
							//Insert Station Options
							?><option value="<?php echo $stationOptions[$i]['stationid']; ?>"><?php echo $stationOptions[$i]['stopname']; ?></option>
						<?php
						}
					?>
				</select>
				<label>Select Ship</label>
				<select class="form-control" id="shipSelected">
				<?php
						$Ship = new Ship();
						$ships = $Ship->getAllShips();				
						for($i = 0; $i < count($ships); $i++){
							?><option value="<?php echo $ships[$i]['shipid']; ?>"><?php echo $ships[$i]['shipname']; ?></option>
						<?php
						}
					?>
				</select>
				<button id="addTripBtn" class="btn btn-primary">Add</button>
			</div>
		</div>
	</div>
</div>

<script>
document.getElementById("addAdminBtn").addEventListener("click", addAdmin);
document.getElementById("addStationBtn").addEventListener("click", addStation);
document.getElementById("addShipBtn").addEventListener("click", addShip);
document.getElementById("addTripBtn").addEventListener("click", addTrip);

function addAdmin(){
	var selectElement = document.getElementById("selectAdmin");
	var selectedUser = selectElement.options[selectElement.selectedIndex].value;	
	
	httpGetAsync("api/addAdmin.php?id="+selectedUser, function(response){
		console.log(response);
	});
}

function addStation(){
	var stationNameInput = document.getElementById("stationNameInput").value;
	var stationLocationInput = document.getElementById("stationLocationInput").value;
	
	httpGetAsync("api/addStation.php?name="+stationNameInput+"&loc="+stationLocationInput, function(response){
		console.log(response);
	});
}

function addShip(){
	var shipName = document.getElementById("shipNameInput").value;
	var shipCap = document.getElementById("shipCapacityInput").value;
	
	httpGetAsync("api/addShip.php?name="+shipName+"&cap="+shipCap, function(response){
		console.log(response);
	});
}

function addTrip(){
	var departDate = document.getElementById("departDateInput").value;
	var departTime = document.getElementById("departTimeInput").value;
	var arrivalDate = document.getElementById("arrivalDateInput").value;
	var arrivalTime = document.getElementById("arrivalTimeInput").value;
	var timeInPort = document.getElementById("timeInPortInput").value;
	
	alert(document.getElementById("departDateInput").valueAsNumber);	
	var srcStop = document.getElementById("departPortSelected").value;
	
	var dstStop = document.getElementById("arrivalPortSelected").value;
	
	var shipId = document.getElementById("shipSelected").value;
	
	var departTimestamp = document.getElementById("departDateInput").valueAsNumber + document.getElementById("departTimeInput").valueAsNumber;
	var arrivalTimestamp = document.getElementById("arrivalDateInput").valueAsNumber + document.getElementById("arrivalTimeInput").valueAsNumber;
	
	
	httpGetAsync("api/addTrip.php?dep="+departTimestamp+"&arr="+arrivalTimestamp+"&tip="+timeInPort+"&src="+srcStop+"&dst="+dstStop+"&ship="+shipId, function(response){
		console.log(response);
	});
}
</script>

<?php include 'footer.php'; ?>
