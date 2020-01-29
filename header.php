<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<?php require_once 'php/User.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>
		Alba Wildlife Cruises
	</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Ferry Industries">
    <meta name="author" content="Ali Mac">
	<script src="js/main.js"></script>
	<!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<header>
		<!--Title, Background Image, Button for Login-->
		<div class="jumbotron " style="background-image: url('assets/imgs/boatimage.jpg')">
			<div class="row">
				<div class="col">
					<h1 class="display-3" style="">Alba Wildlife Cruises</h1>
				</div>
				<div class="col" style="text-align:right">
				
					
					<?php require_once 'php/LoginHandler.php'; ?>
					<?php $LoginHandler = new LoginHandler(); ?>
					
					
					<?php $sessionID = $LoginHandler->isLoggedIn(); ?>
					<?php $currentUser = $LoginHandler->getUser($sessionID);?>

					<?php if($currentUser["is_admin"] == 1){ ?>
						<?php if(basename($_SERVER['PHP_SELF']) != "admin.php"){ ?>
							<button class="btn btn-danger" onclick="location.href='admin.php';">Admin Page</button>
						<?php }else{ ?>
							<button class="btn btn-primary" onclick="location.href='index.php';">Back to Index Page</button>
						<?php } ?>
					<?php } ?>
					
					
					<?php if($currentUser["userID"] != null){ ?><h4><a href="customer.php?id=<?php echo $currentUser["userID"]; ?>"><?php echo $currentUser["firstname"]." ".$currentUser["lastname"]; ?></a> | <a href="logout.php">Logout</a></h4><?php }else{ ?>
					<button type="button" class="btn btn-primary" onclick="location.href='login.php';">Login/Register</button>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="row" style="text-align:center;">
				<div class="col" style="background-color:black; font-color:white; padding-top:15px; padding-bottom:15px;">
					<a href="index.php">Home</a>
				</div>
				<div class="col" style="background-color:black; font-color:white; padding-top:15px; padding-bottom:15px;">
					<a href="customer.php">Customer</a>
				</div>
				<?php if($currentUser["userID"] != null){ ?>
				<div class="col" style="background-color:black; font-color:white; padding-top:15px; padding-bottom:15px;">
					<a href="logout.php">Logout</a>
				</div>
				<?php }else{ ?>
				<div class="col" style="background-color:black; font-color:white; padding-top:15px; padding-bottom:15px;">
					<a href="login.php">Login</a>
				</div>
				<?php } ?>
			</div>
	</header>