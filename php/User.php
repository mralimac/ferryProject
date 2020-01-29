<?php require_once 'Database.php'; ?>
<?php
class User extends Database{
	
	//Checks if the user has enough trips to qualify as a frequent user. If so then it updates the database to reflect that
	function checkIfUserIsFrequent($userid){
		$result = $this->query("SELECT number_of_trips FROM users WHERE userid = $userid");
		if(!$result){
			return false;
		}
		while($row = mysqli_fetch_assoc($result)){
			$numberOfTrips = array("number_of_trips" =>$row['number_of_trips']);
			$numberOfTrips = (int)$numberOfTrips["number_of_trips"];
			if($numberOfTrips > 5){
				$result = $this->query("UPDATE users SET is_frequent = 1 WHERE userid = $userid");
				return true;
			}else{
				return false;
			}
		}
		return false;
	}
	
	//This creates a user, usually through the register page
	function createUser($firstname, $lastname, $passwordHash, $email, $address, $telphone, $age){		
		$result = $this->query("INSERT INTO users VALUES(0,'$firstname','$lastname','$passwordHash','$email','$address','$telphone', 0, 0, 0, $age)");
		if($result){
			return array("result" => true, "message" => "Person Successfully Added", "code" => 200);
		}else{
			return array("result" => false, "message" => "Adding Person Failed", "code" => 106);
		}
	}
	
	//Returns a list of all users
	function getAllUsers(){
		$result = $this->query("SELECT * FROM users");
		$rows = array();
		while($row = mysqli_fetch_assoc($result)){
			array_push($rows, array("userid"=>$row['userid'],"firstname"=>$row['firstname'], "lastname"=>$row['lastname'], "email"=>$row['email'], "address"=>$row['address'], "telphone"=>$row['telphone'], "number_of_trips"=>$row['number_of_trips'], "is_frequent"=>$row['is_frequent'], "is_admin"=>$row['is_admin'], "age"=>$row['age']));
		}
		return $rows;
	}
	
	//Checks if a user is admin
	function isUserAdmin($userId){
		$result = $this->query("SELECT is_admin FROM users WHERE userid = '$userId' AND is_admin = 1");
		if(mysqli_num_rows($result) == 1){
			return true;
		}else{
			return false;
		}
	}
	
	//Updates a user to have admin permissions
	function makeUserAdmin($userId){
		$result = $this->query("UPDATE users SET is_admin = 1 WHERE userid = '$userId'");
		if($result){
			return true;
		}else{
			return false;
		}
		
	}
}
?>