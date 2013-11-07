<html>
	<head>
		<title>Add Users</title>
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
					echo "<h1>Add or update a user</h1>";
					// Display form to add/update user.
					echo '
					<form method="post" action="addUpdateUsersSubmit.php" enctype="multipart/form-data">
						<label>Username:&nbsp;&nbsp;<input type="text" name="username" /></label><br />
						<label>Password:&nbsp;&nbsp;<input type="password" name="password" /></label><br />
						<label>First name:&nbsp;&nbsp;<input type="text" name="firstname" /></label><br />
						<label>Last name:&nbsp;&nbsp;<input type="text" name="lastname" /></label><br />
						<label>Status (0 for admin rights, 1 for manager rights, 2 for regular users):&nbsp;&nbsp;<input type="text" name="status" /></label><br />
						<br />
						<input type="submit" name="submit" value="Submit" />
						<input type="reset" name="clear" value="Clear" />
					</form><br /><br /><a href="login_check.php">Go back</a>';
				}else
					echo 'You do not have the permissions to do that.<br /><br /><a href="login_check.php">Go back</a>';
			}
			else
				echo 'Please <a href="index.html">login</a>.';
		?> 
	</div>
	</body> 
</html>