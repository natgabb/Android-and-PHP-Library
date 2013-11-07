<html>
<head>
	<title>Trying to login</title>
	<link type="text/css" rel="Stylesheet" href="stylesheet.css" />
</head>
<body>
	<div id="contentDiv">
		<?php
			if(!isset($_POST['username']) || !isset($_POST['password']))
				header("location: index.html");
			$username = strip_tags($_POST['username']);
			$password = strip_tags($_POST['password']);
			if(empty($username) || empty($password))
				echo "<h1>Invalid username or password</h1>Please go back and make sure to fill out all the fields.";
			else{
				require_once('saltpassword.php');
				$password_token = saltPassword($_POST['password']);
				
				require_once('maintain_users.php');
				$login_result = viewUserByName($_POST['username']);
				if($login_result){
					$rows = mysql_num_rows($login_result);
					if($rows == 0)
					{
						echo "<h1>Invalid username or password</h1>The username you entered does not exist.";
					}
					else
					{
						$row = mysql_fetch_row($login_result);
						$user_password = $row[2];
						if($user_password == $password_token)
						{
							echo "Login was successful...";
							session_start();
							
							//Store session data
							$_SESSION['username'] = $_POST['username'];
							$_SESSION['status'] = $row[5];
							mysql_free_result($login_result);
							// Status 0 : Admin, Status 1: DBManager, Status 2: User
							header("location: login_check.php");
						}
						else
							echo "<h1>Invalid username or password</h1>You entered an invalid username or password.";
					}
				}
				closeConnection();
			}
			
			echo '<br /><br /><a href="index.html">Go back</a>';
		?>
	</div>
</body>
</html>