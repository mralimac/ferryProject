<?php require_once 'header.php'; ?>
<?php require_once 'php/LoginHandler.php'; ?>
<div class="container" style="background-color: #99c2ff; padding:30px; text-align:center">
	<button id="single" class="btn btn-warning" onclick="logout(this.id)">Logout this session</button>
	<button id="all" class="btn btn-danger" onclick="logout(this.id)">Logout all sessions</button>
</div>
<script>
function logout(elementID){
	var userID = "<?php echo $currentUser["userID"]; ?>";
	httpGetAsync("api/logout.php?id="+userID+"&type="+elementID, function(){
		console.log("Logout")
		location.href='../ferry';
	});
}
</script>

<?php require_once 'footer.php'; ?>