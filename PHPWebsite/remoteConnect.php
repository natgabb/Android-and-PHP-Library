<?php

	// Connects to the database
	require_once('database_connect.php');
		
	if(!$db_server)
		die ("Could not connect to the database: " . mysql_error() . "<br/>");
		
	@mysql_select_db($db_schema)
		or die ("Unable to select database: " . mysql_error() . "<br/>");
	
	// Query strings
	$query = "SELECT * FROM product";	
	$whereClause = " WHERE ";
	$where = false;

	// Checks if the person entered a name. If the name is an empty string,
	// will act as if it was not there.
	if (array_key_exists("name", $_REQUEST)){
		$name = mysql_real_escape_string($_REQUEST['name']);
		if ($name && $name != ""){
			$where = true; 
			$whereClause .= "name = '" . $name . "'";		
		}
	}
	
	// Checks if the person entered a genre. If the genre is an empty string,
	// will act as if it was not there.
	if (array_key_exists("genre", $_REQUEST)){
		$genre = mysql_real_escape_string($_REQUEST['genre']);
		if ($genre && $genre != ""){
			if($where)
				$whereClause .= " AND ";
			else
				$where = true;
			$whereClause .= "genre = '" . $genre . "'";
		}
	}
	
	// Checks if the person entered a platform. If the platform is an empty string,
	// will act as if it was not there.
	if (array_key_exists("platform", $_REQUEST)){
		$platform = mysql_real_escape_string($_REQUEST['platform']);
		if ($platform && $platform != ""){
			if($where)
				$whereClause .= " AND ";
			else
				$where = true;
			$whereClause .= "platform = '" . $platform . "'";
		}
	}
	
	// Checks if the person entered a date. If the date is an empty string,
	// will act as if it was not there.
	if (array_key_exists("date", $_REQUEST)){
		$date = mysql_real_escape_string($_REQUEST['date']);
		if ($date && $date != ""){
			if($where)
				$whereClause .= " AND ";
			else
				$where = true;
			$whereClause .= "modifydate > '" . $date . "'";
		}
	}
	
	// Adds the where clause to the query
	if ($where){
		$query .= $whereClause;
	}
	
	// Prints the query as JSON
	$result = mysql_query($query);
	while($entry = mysql_fetch_assoc($result))
		$output[] = $entry;

	if (isset($output))
		print(json_encode($output));
	
	mysql_close();

?>