<html>
	<head>
		<title>Delete a User</title>
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
					echo "<h1>Delete a User</h1>";
					// Display form to delete a user
					echo '
					<p>Warning, this cannot be undone.</p>
					<form method="post" action="deleteUserSubmit.php" enctype="multipart/form-data">
						<label>Username of user to be deleted:&nbsp;&nbsp;<input type="text" name="username" /></label><br />
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