<?php
	require_once('database_connect.php');
		
	if(!$db_server)
		die ("Could not connect to the database: " . mysql_error() . "<br/>");
		
	@mysql_select_db($db_schema)
		or die ("Unable to select database: " . mysql_error() . "<br/>");
	
	/*
	* Backs up the table as table_backup.
	*/
	function backupTable($p_table_name, $p_table_backup){
		// Escapes for illegal characters and SQL injections
		$table = mysql_real_escape_string($p_table_name);
		$table_backup = mysql_real_escape_string($p_table_backup);
			
		$dropQuery = "DROP TABLE IF EXISTS $table_backup;";
		$createQuery = "CREATE TABLE $table_backup SELECT * FROM $table;";
		
		mysql_query($dropQuery);
		mysql_query($createQuery);
					   
		if(mysql_error()){
			echo "An error was encountered while backing up the table. Table name: '$table'<br/>";			
			echo mysql_error();
		}
		else
			echo "Table updated.<br/>";
	}
	
	/*
	* Restores the backup into the table.
	*/
	function restoreTable($p_table_name, $p_table_backup){
		// Escapes for illegal characters and SQL injections
		$table = mysql_real_escape_string($p_table_name);
		$table_backup = mysql_real_escape_string($p_table_backup);
		
		// Checks that the backup exists before trying to restore it.
		$existsQuery = "SHOW TABLES LIKE '$table_backup';";
		$result = @mysql_query($existsQuery);
		
		if(mysql_num_rows($result) == 1){			
			$dropQuery = "DROP TABLE IF EXISTS $table;";
			$createQuery = "CREATE TABLE $table SELECT * FROM $table_backup;";
			
			@mysql_query($dropQuery);
			@mysql_query($createQuery);
						   
			if(mysql_error()){
				echo "An error was encountered while backing up the table. Table name: '$table'<br/>";			
				echo mysql_error();
			}
			else
				echo "Table updated.<br/>";
		}
		else
			echo "The backup table does not exist. Backup table name: '$table_backup'<br/>";
	}
?>