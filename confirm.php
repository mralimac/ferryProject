<?php include 'header.php'; ?>
<?php require_once 'php/Ferry.php'; ?>
<?php require_once 'securearea.php'; ?>
<?php 
	$orderid = $_GET["o"];
	$Ferry = new Ferry(); 	
	$ferryData = $Ferry->getOrderByOrderID($orderid);
?>

<?php $email = '
<div class="container" style="background-color: #99c2ff; padding:30px;">
	<h1>Thank you for riding with us!</h1>
	<p><strong>Order Details:</strong></p>
	<p>You have booked for: '. $ferryData["departTime"].'</p>
	<p>Adult Seats: '.$ferryData["adultSeats"].'</p>
	<p>Child Seats: '.$ferryData["childSeats"].'</p>
	<p>An email has been sent to '. $currentUser["email"].' to confirm details</p>
</div>
'; ?>

<?php echo $email; ?>

<?php mail($currentUser["email"], "Order Confirmation", $email); ?>
<?php require_once 'footer.php'; ?>


