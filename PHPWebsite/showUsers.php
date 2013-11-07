<html>
	<head>
		<title>Show Users</title>
		<link type="text/css" rel="Stylesheet" href="stylesheet.css" />
	</head>
	<body>
	<div id="contentDiv">
		<?php 
			session_start();
			if(isset($_SESSION['status']))
			{
			$status = $_SESSION['status'];
				if($status == 0){
					require_once('maintain_users.php');
						
						$result = viewAllUsers();
						if($result){
							$rows = mysql_num_rows($result);
							echo "<h1>$rows users</h1>";
							if($rows != 0){
								for($j = 0; $j < $rows; $j++){
									$row = mysql_fetch_assoc($result);
									printOneUser($row);
								}
							}							
							echo '<br /><br /><a href="login_check.php">Go back</a>';
						}
				}else
					echo 'You do not have the permissions to do that.<br /><br /><a href="login_check.php">Go back</a>';
			}
			else
				echo 'Please <a href="index.html">login</a>.';
				
			// Prints one product.	
			function printOneUser($productRow)
			{
				echo '<h2>ID: ' . $productRow['_id'] . '</h2><br />';
				echo 'Username: ' . $productRow['Username'] . '<br />';
				echo 'Password: ' . $productRow['Password'] . '<br />';
				echo 'FirstName: ' . $productRow['FirstName'] . '<br />';
				echo 'LastName: ' . $productRow['LastName'] . '<br />';
				echo 'Status: ' . $productRow['Status'] . '<br />';
				echo 'CreateDate: ' . $productRow['CreateDate'] . '<br />';
				echo 'ModifyDate: ' . $productRow['ModifyDate'] . '<br /><br />';
			}
		?> 
	</div>
	</body> 
</html>