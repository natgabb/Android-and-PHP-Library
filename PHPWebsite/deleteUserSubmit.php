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
				if($status == 0 || $status == 1){
					echo "<h1>Deleting a user</h1>";
					$username = strip_tags($_POST['username']);
					
					if(!empty($username)){
						require_once('maintain_users.php');
						deleteUserFromName($username);
					}else
						echo 'Please go back and make sure to fill out all the fields.';
					echo '<br /><br /><a href="deleteUser.php">Go back</a>';
				}else
					echo "You do not have the permissions to do that.";
			}
			else
				echo 'Please <a href="index.html">login</a>.';
		?>
	</div>		
	</body> 
</html>