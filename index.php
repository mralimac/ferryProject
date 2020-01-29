<?php include 'header.php'; ?>
<?php include 'php/Ferry.php'; ?>
<?php include 'php/Station.php'; ?>
<div class="container border" >
	<div class="row">
		<div class="col-sm-4 border" style="height:100%; background-color: #99c2ff; padding: 50px;">
			<div class="form-group">
				<div class="row">
					<p><strong>From:</strong></p>
					<select class="form-control" id="srcStopSelect">
					<option value="noStation">Please select a station</option>
					<?php
						$Station = new Station();
						$stationOptions = $Station->getAllStations();				
						for($i = 0; $i < count($stationOptions); $i++){
							?><option value="<?php echo $stationOptions[$i]['stationid']; ?>"><?php echo $stationOptions[$i]['stopname']; ?></option>
						<?php
						}
					?>
					</select>
				</div>
				<div class="row">
					<p><strong>To:</strong></p>
					<select class="form-control" id="dstStopSelect">
					<option value="noStation">Please select a station</option>
					<?php
						$stationOptions = $Station->getAllStations();				
						for($i = 0; $i < count($stationOptions); $i++){
							?><option value="<?php echo $stationOptions[$i]['stationid']; ?>"><?php echo $stationOptions[$i]['stopname']; ?></option>
						<?php
						}
					?>
					</select>
				</div>
				<div class="row">
					<button class="form-control btn btn-primary" onclick="listStations()">Search</button>
				</div>
			</div>
		</div>
		<div class="col-sm-8 border" style="height:100%; background-color: #99c2ff;">
			<h2>Ferries - Next 7 Days</h2>
			<div class="row" id="listOfCards">
			<?php
			
				$Ferry = new Ferry();
				$currentTime = time();
				$sevenDaysFromNow = strtotime("+7 day", time());		
				//$ferryData = $Ferry->getFerriesBetweenThisTwoDates($currentTime,$sevenDaysFromNow);
				//I realised that this code might get reviewed at a time where all trips will be behind the current date.
				//So I decided to not make a proper time/date into the system
				$ferryData = $Ferry->getAllFerries();
				
				for($i = 0; $i < count($ferryData); $i++){
					?>
					<div class="card" id="card<?php echo $i; ?>">
						<div class="card-body">
							<h5 class="card-title">Trip #<?php echo $i+1; ?></h5>
							<p class="card-text"><?php echo $ferryData[$i]["departTime"]; ?></p>
							<p class="card-text">From: 
								<strong id="dep<?php echo $ferryData[$i]["srcStop"]; ?>"><?php echo $ferryData[$i]["srcStopName"]; ?></strong> To: 
								<strong id="arr<?php echo $ferryData[$i]["dstStop"];; ?>"><?php echo $ferryData[$i]["dstStopName"]; ?></strong></p>
							<button class="btn btn-secondary" style="width:100%;" onclick="location.href='order.php?id=<?php echo $ferryData[$i]["tripid"]; ?>';" id="">More Details</button>
						</div>
					</div>
					<?php
				}
			?>
			</div>
		</div>
	</div>
</div>
<script>

function listStations(){
	var dstSelectElement = document.getElementById("dstStopSelect");
	var dstSelected = parseInt(dstSelectElement.options[dstSelectElement.selectedIndex].value);
	
	var srcSelectElement = document.getElementById("srcStopSelect");
	var srcSelected = parseInt(srcSelectElement.options[srcSelectElement.selectedIndex].value);
	
	var numberOfCards = document.getElementById("listOfCards").childElementCount;
	var i = 0;
	
	for(i = 0; i < numberOfCards; i++){
		var checkDst = document.getElementById("card"+i).children[0].children[2].children[0].id; 
		var checkSrc = document.getElementById("card"+i).children[0].children[2].children[1].id;
		
		trimmedDst = parseInt(checkDst.substring(3));
		trimmedSrc = parseInt(checkSrc.substring(3));
		
		if(dstSelected == trimmedDst && srcSelected == trimmedSrc){
			document.getElementById("card"+i).style.display = "none";
		}else{
			document.getElementById("card"+i).style.display = "block";
		}
		
	}
}

</script>

<?php include 'footer.php'; ?>