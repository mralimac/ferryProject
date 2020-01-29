<?php require_once 'header.php'; ?>
<?php require_once 'php/Ferry.php'; ?>
<?php require_once 'php/User.php'; ?>
<?php require_once 'securearea.php'; ?>
<?php $Ferry = new Ferry(); ?>
<?php 
	$User = new User();
	$userid = $currentUser["userID"];
	$isFrequent = $User->checkIfUserIsFrequent($userid);
	$Ferry = new Ferry();
	$ferries = $Ferry->getOrderByUserID($userid);
?>


<div class="container border" style="background-color: #99c2ff; padding: 50px;">
	<h1><?php echo $currentUser["firstname"] . " " . $currentUser["lastname"]; ?></h1>
	<?php if($isFrequent == 1){ ?>
	<div class="row">
		<div class="col">
			<h4 style="background-color:white; text-align:center; padding:10px; border-radius:10px;">Hello Frequent Customer! You've been invited to a celidih on the 27th of October 2019!<br>You have also earned a 50% discount on the last six trips this season!</h4>
		</div>
	</div>
	<?php } ?>
	<button class="btn btn-primary" onclick="location.href='index.php';">Book Another Trip</button>
	<h4>Pending Trips</h4>
	<div class="row" style="padding:10px;">
	<?php
		for($i = 0; $i < count($ferries); $i++){
			?>
			<div class="card" style="background-color:white; border-radius:10px; width: 50%;">
				<div class="card-body" id="<?php echo $ferries[$i]["orderid"]; ?>">
					<h5 class="card-title">Trip #<?php echo $i; ?></h5>
						<ul class="list-group list-group-flush">
							<li class="list-group-item"><strong id="departText"><?php echo $ferries[$i]["departTime"]; ?></strong></li>
							<li class="list-group-item" id="adultSeats">Adult Seats: <strong id="adultText"><?php echo $ferries[$i]["adultSeats"]; ?></strong> <button onclick="amend(this.parentElement, this.parentElement.children[0].innerText, this);" id="editAdult" class="btn btn-warning">Amend</button></li>
							<li class="list-group-item" id="childSeats">Child Seats: <strong id="childText"><?php echo $ferries[$i]["childSeats"]; ?></strong> <button onclick="amend(this.parentElement, this.parentElement.children[0].innerText, this);" id="editChild" class="btn btn-warning">Amend</button></li>
						</ul>
					<button class="btn btn-danger" onclick="removeBooking(this.parentElement.id)">Delete Booking</button>
				</div>
			</div>
			<?php
		}
	?>
	</div>
</div>
<script>
function amend(parentElement, originalLog, buttonElement){
	var orderID = parentElement.parentElement.id;
	var elementTagName = parentElement.children[0].tagName;
	if(elementTagName == "INPUT"){
		var elementType = parentElement.id;
		var inputValue = parentElement.children[0].value;
		httpGetAsync("api/editBooking.php?value="+inputValue+"&type="+elementType+"&id="+orderID, function(){
			var amendInput = document.createElement('strong');
			amendInput.innerText = inputValue;
			parentElement.replaceChild(amendInput, parentElement.children[0]);
			buttonElement.innerText = "Amend";
		});
	}else{
		var amendInput = document.createElement('input');
		amendInput.value = originalLog;
		parentElement.replaceChild(amendInput, parentElement.children[0]);
		buttonElement.innerText = "Confirm";
	}
}

function removeBooking(id){
	httpGetAsync("api/deleteBooking.php?id="+id, function(response){
		console.log(response);
	});
}
</script>
<?php require_once 'footer.php'; ?>