<?php
abstract class Database{
	private $username = "in14004614";
	private $password = "956785ab";
	private $schema = "in14004614";
	private $host = "localhost";
	private $conn;
	
	//Starts a MySQL connection
	function connection(){
		if($this->conn != NULL){
			return $this->conn;
		}else{
			$this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->schema);
			return $this->conn;
		}
	}
	
	//Ends a MySQL connection
	function disconnect(){
		if($this->conn != NULL){
			mysqli_close($this->conn);
			return true;
		}else{
			return false;
		}		
	}
	
	//This executes a MySQL Query using the parameter $querySting as the Query String, returns the result
	function query($queryString){
		$conn = $this->connection();
		if($conn != NULL){			
			$mysqliResult = mysqli_query($conn, htmlspecialchars(strip_tags($queryString)));			
			return $mysqliResult;
		}else{
			return null;
		}
	}
	
	function getStatus(){
		var_dump(mysqli_get_connection_stats($this->conn));
	}
}

?>