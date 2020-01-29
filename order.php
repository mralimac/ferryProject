<?php include 'header.php'; ?>
<?php require_once 'php/Ferry.php'; ?>
<?php require_once 'securearea.php'; ?>
<?php $Ferry = New Ferry(); ?>
<?php $ferryID = $_GET['id']; ?>
<?php $ferryData = $Ferry->getFerry($ferryID); ?>
<div class="container" style="background-color: #99c2ff; padding:30px;">
	<div class="row">
		<div class="col">
			<h2>Trip Details</h2>
			<p>Departs From: <b><?php echo $ferryData['srcStopName']; ?> at <?php echo $ferryData['departureTime']; ?></b></p>
			<p>Arrives At: <b><?php echo $ferryData['dstStopName']; ?> at <?php echo $ferryData['arrivalTime']; ?></b></p>
			<p>Seats Remaining: <b id="seatsLeft"><?php if($ferryData['seatsLeft'] != null){ echo $ferryData['seatsLeft']; }else{ echo $ferryData['shipCap']; }?></b></p>
			<?php if($ferryData['hasDisabled'] == false){ ?><p>Wheelchair Required: <input type="checkbox" id="hasDisabledInput"></p><?php }else{?><p class="text-danger" id="noWheelchair"><b>Unforunately, there is no wheelchair spaces left on this trip</b></p><?php } ?>
			<div class="row">
				<input type="hidden" value="<?php echo $_GET['id']; ?>" id="idNumber">
				<input type="hidden" value="<?php echo $currentUser["userID"]; ?>" id="userid">
				<input type="hidden" value="<?php echo md5(rand()); ?>" id="orderid">
				<div class="col">
					<label for="numberOfAdults">Number of Adults</label>
					<input type="int" class="form-control" name="numberOfAdults" id="numberOfAdults" onkeyup="checkForm()" required>
					<small id="seatWarning" style="display:none" class="text-danger">The number of seats you have requested exceeds the number available</small>
				</div>
				<div class="col">
					<label for="numberOfChilds">Number of Children</label>
					<input type="int" class="form-control" name="numberOfChilds" id="numberOfChilds" onkeyup="checkForm()" required>
				</div>
			</div><br>
			<button class="btn btn-primary" id="makeBookingBtn">Book Trip</button>
		</div>
	</div>
</div>
<script>
document.getElementById("makeBookingBtn").addEventListener("click", makeOrder);

function checkForm(){
	var adultSeats = parseInt(document.getElementById("numberOfAdults").value);
	if(Number.isNaN(adultSeats)){
		adultSeats = 0;
	}
	var childSeats = parseInt(document.getElementById("numberOfChilds").value);
	if(Number.isNaN(childSeats)){
		childSeats = 0;
	}
	var totalSeatsRequested = adultSeats + childSeats;
	console.log("totalSeats" + totalSeatsRequested);
	var remainingSeats = parseInt(document.getElementById("seatsLeft").innerText);
	
	if(totalSeatsRequested > remainingSeats){
		document.getElementById("seatWarning").style.display = "inline";		
	}else{
		document.getElementById("seatWarning").style.display = "none";
	}
}



function makeOrder(){
	var tripid = document.getElementById("idNumber").value;
	var userid = document.getElementById("userid").value;
	var adultSeats = parseInt(document.getElementById("numberOfAdults").value);
	var childSeats = parseInt(document.getElementById("numberOfChilds").value);
	var hasDisabled = document.getElementById("hasDisabledInput").value;
	var remainingSeats = parseInt(document.getElementById("seatsLeft").innerText);
	
	if(Number.isNaN(adultSeats)){
		adultSeats = 0;
	}
	
	if(Number.isNaN(childSeats)){
		childSeats = 0;
	}
	
	
	var totalSeatsRequested = adultSeats + childSeats;
	
	
	
	
	if(totalSeatsRequested > remainingSeats){
		console.log("Too many!");
		return;
	}
	
	if(hasDisabled == "on"){
		hasDisabled = 1;
	}else{
		hasDisabled = 0;
	}
	
	var orderid = document.getElementById("orderid").value;
	
	httpGetAsync("api/makeOrder.php?o="+orderid+"&trip="+tripid+"&user="+userid+"&adult="+adultSeats+"&child="+childSeats+"&dis="+hasDisabled, function(response){
		console.log(response);
		if(response == true){
			location.href='confirm.php?o='+orderid;
		}
	});
}
</script>


<?php include 'footer.php'; ?>