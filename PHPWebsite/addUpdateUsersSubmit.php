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
					echo "<h1>Adding/Updating a user</h1>";
					$username = strip_tags($_POST['username']);
					$password = strip_tags($_POST['password']);
					$firstname = strip_tags($_POST['firstname']);
					$lastname = strip_tags($_POST['lastname']);
					$statusForm = strip_tags($_POST['status']);
					if(!empty($username) && !empty($password)
					&& !empty($firstname) && !empty($lastname)
					&& $statusForm != ""){
						if($statusForm == '0' || $statusForm == '1' || $statusForm == '2'){
							require_once('maintain_users.php');
							require_once('saltpassword.php');
							$saltpass = saltPassword($password);
							$result = viewUserByName($username);
							$rows = mysql_num_rows($result);
							if($rows > 0){
								// This username exists, therefore you need to update.
								$row = mysql_fetch_assoc($result);
								$id = $row['_id'];
								updateUser($id, $username, $saltpass, $firstname, $lastname, $statusForm);
							}
							else{
							// This is a new user.
								addUser($username, $saltpass, $firstname, $lastname, $statusForm);
							}
						}
						else
							echo 'The status you submitted is invalid.';
					}else
						echo 'Please go back and make sure to fill out all the fields.';
					echo '<br /><br /><a href="addUpdateUsers.php">Go back</a>';
				}else
					echo "You do not have the permissions to do that.";
			}
			else
				echo 'Please <a href="index.html">login</a>.';
		?> 
	</div>
	</body> 
</html>