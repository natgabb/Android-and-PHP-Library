<?php
	require_once('database_connect.php');
		
	if(!$db_server)
		die ("Could not connect to the database: " . mysql_error() . "<br/>");
		
	@mysql_select_db($db_schema)
		or die ("Unable to select database: " . mysql_error() . "<br/>");
	
	/*
	* Adds a user to the user table. The password it receives is assumed to be already encrypted.
	*/
	function addUser($p_username, $p_password, $p_firstname, $p_lastname, $p_status){
		global $db_server;
		
		// Escapes for illegal characters and SQL injections
		$user = mysql_real_escape_string($p_username);
		$pass = mysql_real_escape_string($p_password);
		$first = mysql_real_escape_string($p_firstname);
		$last = mysql_real_escape_string($p_lastname);
		$stat = mysql_real_escape_string($p_status);
		
		$insert_query = "INSERT INTO users(username, password, firstname, lastname, status, " 
						. "createdate, modifydate) VALUES ('$user', '$pass', '$first', " 
						. "'$last', $stat, NOW(), NOW());";						
		mysql_query($insert_query);
		
		if(mysql_affected_rows() == 0)
			echo "An error was encountered while adding the user: " . mysql_error() . "<br/>";
		else
			echo "User added.<br/>";			
	}
		
	/*
	* Deletes a user from the user table.
	*/
	function deleteUser($p_user_id){
		global $db_server;
		
		// Escapes for illegal characters and SQL injections
		$id = mysql_real_escape_string($p_user_id);
		
		$deleteQuery = "DELETE FROM users WHERE _id = $id";
		mysql_query($deleteQuery);
		
		if(mysql_affected_rows() == 0){
			echo "An error was encountered while deleting the user. User id: $id.<br/>";
			echo "Verify that the user exists.<br/>";
		}
		else
			echo "User deleted.<br/>";
	}
		
	/*
	* Deletes a user from the user table with a user name.
	*/
	function deleteUserFromName($p_username){
		global $db_server;
		
		// Escapes for illegal characters and SQL injections
		$user = mysql_real_escape_string($p_username);
		
		$deleteQuery = "DELETE FROM users WHERE username = '$user'";
		mysql_query($deleteQuery);
		
		if(mysql_affected_rows() == 0){
			echo "An error was encountered while deleting the user. Username: $user.<br/>";
			echo "Verify that the user exists.<br/>";
		}
		else
			echo "User deleted.<br/>";
	}
	
	/*
	* Updates a user from the user table.
	* The password it receives is assumed to be already encrypted.
	*/
	function updateUser($p_user_id, $p_username, $p_password, $p_firstname, $p_lastname, $p_status){
		global $db_server;
		
		// Escapes for illegal characters and SQL injections
		$id = mysql_real_escape_string($p_user_id);
		$user = mysql_real_escape_string($p_username);
		$pass = mysql_real_escape_string($p_password);
		$first = mysql_real_escape_string($p_firstname);
		$last = mysql_real_escape_string($p_lastname);
		$stat = mysql_real_escape_string($p_status);
		
		$update_query = "UPDATE users SET username = '$user', password = '$pass', " 
						. "firstname = '$first', lastname = '$last', status = $stat, " 
						. "modifydate = NOW() WHERE _id = $id";		
		mysql_query($update_query);
		
		if(mysql_affected_rows() == 0){
			echo "An error was encountered while updating the user. User id: $id.<br/>";
			echo "Verify that the user exists.<br/>";
		}
		else
			echo "User updated.<br/>";
	}
	
	/*
	* Returns a user from the user table.
	* The user has to verify that the result set contains a user.
	*/
	function viewUser($p_user_id){
		// Escapes for illegal characters and SQL injections
		$id = mysql_real_escape_string($p_user_id);
		
		$selectQuery = "SELECT * FROM users WHERE _id = $id";
		$result = mysql_query($selectQuery);
		
		if(!$result){
			echo "An error occured while retrieving the user.<br/>";
			echo mysql_error();
		}
		
		return $result;
	}
	
	/*
	* Returns a user from the user table.
	* The user has to verify that the result set contains a user.
	*/
	function viewUserByName($p_username){
		// Escapes for illegal characters and SQL injections
		$user = mysql_real_escape_string($p_username);
		
		$selectQuery = "SELECT * FROM users WHERE username = '$user'";
		$result = mysql_query($selectQuery);
		
		if(!$result){
			echo "An error occured while retrieving the user.<br/>";
			echo mysql_error();
		}
		
		return $result;
	}
	
	/*
	* Returns all the users from the database.
	* The user has to verify that the result set contains a users.
	*/
	function viewAllUsers() {
		$selectQuery = "SELECT * FROM users";
		$result = mysql_query($selectQuery);
		
		if(!$result){
			echo "An error occured while retrieving the users.<br/>";
			echo mysql_error();
		}
		
		return $result;
	}
	
	/*
	* Closes the database connection.
	*/
	function closeConnection(){
		global $db_server;
		mysql_close($db_server);
	}
?>