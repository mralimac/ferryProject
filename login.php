<?php include 'header.php'; ?>
<?php require_once 'php/LoginHandler.php'; ?>
<div class="container" style="background-color: #99c2ff; padding:30px;">
	<div class="form-group centralContainer">
		<label for="username">Enter email</label>
		<input type="text" id="username" name="username" class="form-control" placeholder="Enter email">
		<label for="password">Enter password</label>
		<input type="password" id="password" name="password" class="form-control" placeholder="Enter password">
		<br>
		<button id="loginBtn" class="btn btn-primary">Login</button>
		<button id="goRegisterBtn" onclick="location.href='register.php';" class="btn btn-info">Register</button>
	</div>
</div>

<script>
document.getElementById("loginBtn").addEventListener("click", loginUser);

function loginUser(){
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value;
	
	httpGetAsync("api/loginUser.php?u="+username+"&p="+password, function(response){
		console.log(response);
		if(response != false){
			location.href='../ferry';
		}
	});
}

</script>

<?php include 'footer.php'; ?>