<?php
require_once 'Database.php';

class LoginHandler extends Database{
	private $cookieID;
	private $sessionID;
	
	//This checks if the user is logged in
	function isLoggedIn(){
		if(isset($_COOKIE['loginToken'])){
			$cookieID = $_COOKIE['loginToken'];			
		}else{
			
			$cookieID = 0;
		}
		$userAgent = "No User Agent";
		$queryString = "SELECT userAgent, sessionID FROM activeSessions WHERE cookieID = '$cookieID'";
		$queryResult = $this->query($queryString);
		while($row = mysqli_fetch_assoc($queryResult)){
				$userAgent = $row['userAgent'];
				$sessionID = $row['sessionID'];
		}
		
		if(mysqli_num_rows($queryResult) > 0){
			$newCookieID = md5(rand());
			$lastpage = basename($_SERVER["SCRIPT_FILENAME"]);
			$queryString = "UPDATE activeSessions SET cookieID = '$newCookieID', lastPage = '$lastpage' WHERE sessionID = '$sessionID' AND cookieID = '$cookieID'";
			$queryResult = $this->query($queryString);
			if($queryResult){				
				setcookie('loginToken', $newCookieID, time() + 60*60*24*365, "/", "comp-hons.uhi.ac.uk");
				return $sessionID;
			}else{
				setcookie('loginToken', "", time()+1, "/");
				return null;
			}
		}else{
			setcookie('loginToken', "", time()+1, "/");
			return null;
		}
	}
	
	//Gets the last page that the user visited based on cookie data
	function getLastPage($cookieID){
		$queryString = "SELECT lastpage FROM activeSessions WHERE cookieID = '$cookieID'";
		$queryResult = $this->query($queryString);
		while($row = mysqli_fetch_assoc($queryResult)){
			return array("lastpage" => $row['lastpage']);
		}
	}
	
	//Get user based on cookieid
	function getUserBasedOnCookie($cookieID){
		$queryString = "SELECT users.address, users.email, users.telphone, users.userid, users.firstname, users.lastname, users.is_frequent, users.is_admin, age
						FROM activeSessions
						INNER JOIN users ON in14004614.activeSessions.sessionID = users.userid
						WHERE cookieID = '$cookieID'";
						
		$queryResult = $this->query($queryString);
		
		while($row = mysqli_fetch_assoc($queryResult)){
			return json_encode(array("userAddress" => $row['address'], "email" => $row['email'], "userTelNo" => $row["telphone"], "userID" => $row["userid"], "firstname" => $row["firstname"], "lastname" => $row["lastname"], "isFrequent" => $row["is_frequent"], "is_admin" => $row["is_admin"], "age" => $row["age"]));
		}
	}
	
	//Gets the user based on thier sessionID number. Session number is retrieved from cookies
	function getUser($sessionID){
		$queryString = "SELECT * FROM users WHERE userid = $sessionID";
		$queryResult = $this->query($queryString);
		if(!$queryResult){
			return null;
		}
		while($row = mysqli_fetch_assoc($queryResult)){
			return array("userAddress" => $row['address'], "email" => $row['email'], "userTelNo" => $row["telphone"], "userID" => $row["userid"], "firstname" => $row["firstname"], "lastname" => $row["lastname"], "isFrequent" => $row["is_frequent"], "is_admin" => $row["is_admin"], "age" => $row["age"]);
		}
		if($queryResult && $staffID != null){
			return array("userAddress" => $row['address'], "email" => $row['email'], "userTelNo" => $row["telphone"], "userID" => $row["userid"], "firstname" => $row["firstname"], "lastname" => $row["lastname"], "isFrequent" => $row["is_frequent"], "is_admin" => $row["is_admin"], "age" => $row["age"]);
		}else{
			return null;
		}
	}
	
	//This function is usually run at the top of a page to verify if the user is allowed to view it
	function secureArea($sessionID){
		$getUser = $this->getUser($sessionID);
		if($getUser == null && basename($_SERVER['PHP_SELF']) != 'index.php'){
			header('Location: index.php');
		}
	}
	
	//This function logins in the user. This creates an entry in the active sessions table that keeps the user logged in
	function login($username, $unEncryptedPassword){
		$queryString = "SELECT pass_word, userid FROM users WHERE email = '$username'";
		$queryResult = $this->query($queryString);
		if(mysqli_num_rows($queryResult) > 0){
			
			while($row = mysqli_fetch_assoc($queryResult)){
				$hashedPassword = $row['pass_word'];
				$sessionID = $row['userid'];
			}
			if(password_verify($unEncryptedPassword, $hashedPassword)){
				$cookieID = md5(rand());
				
				$this->sessionID = $sessionID;
				$this->cookieID = $cookieID;
				$userAgent = $_SERVER['HTTP_USER_AGENT'];
				
				$queryString = "INSERT INTO activeSessions VALUES('$userAgent','$sessionID', '$cookieID', 'index.php')";
				$queryResult = $this->query($queryString);
				if($queryResult){
					//$combinedValue = $this->cookieID . "/" . $this->sessionID;
					setcookie('loginToken', $this->cookieID, time() + 60*60*24*365, "/", "comp-hons.uhi.ac.uk");
					return json_encode(array("cookieid" => $this->cookieID));
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	//This deletes all active sessions related to a users ID number so all sessions are ended
	function logoutAll($sessionID){
		$queryString = "DELETE FROM activeSessions WHERE sessionID = '$sessionID'";
		$queryResult = $this->query($queryString);
		if($queryResult){
			setcookie('loginToken', "", time(), "/", "comp-hons.uhi.ac.uk");
			return true;
		}else{
			return false;
		}
	}
	
	//This ends only one session of the user so it won't log out other sessions on other devices
	function logoutSession(){
		$cookieID = $_COOKIE['loginToken'];
		
		$queryString = "DELETE FROM activeSessions WHERE cookieID = '$cookieID'";
		$queryResult = $this->query($queryString);
		if($queryResult){
			setcookie('loginToken', "", time(), "/", "comp-hons.uhi.ac.uk");
			return true;
		}else{
			return false;
		}
	}
	
}

?>