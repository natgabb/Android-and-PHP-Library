<html>
	<head>
		<title>Login Check</title>
	<link type="text/css" rel="Stylesheet" href="stylesheet.css" />
	</head>
	<body>
		<div id="contentDiv">
			<div id="centeredDiv">
				<?php
					$defaultForm = '
						<form method="post" action="showProducts.php" enctype="multipart/form-data">
						<input type="submit" name="showProducts" value="Show all products" />
						</form>';
					$addModifyUserForm = '<form method="post" action="addUpdateProducts.php" enctype="multipart/form-data">
						<input type="submit" name="addProducts" value="Add or update a product" />
						</form>
						<form method="post" action="deleteProduct.php" enctype="multipart/form-data">
						<input type="submit" name="deleteProduct" value="Delete a product" />
						</form>';
					$logoff = '
						<hr />
						<form method="post" action="logoff.php" enctype="multipart/form-data">
						<input type="submit" name="logoff" value="Log off" />
						</form>
					';
					session_start();
					if(isset($_SESSION['status']))
					{
					$status = $_SESSION['status'];
						switch($status){
						case 0:
							echo '<h1>Welcome admin</h2>';
							populateForAdmin();
							break;
						case 1:
							echo '<h1>Welcome manager</h2>';
							populateForManager();
							break;
						default:
							echo '<h1>Welcome user</h2>';
							populateForUser();
							break;
						}
					}
					else
						echo 'Please <a href="index.html">login</a>.';
						
					// Populates the HTML for an admin.
					function populateForAdmin(){
						global $defaultForm;
						global $addModifyUserForm;
						global $logoff;
						echo $defaultForm;
						echo $addModifyUserForm;
						echo  '
						<hr />
						<form method="post" action="showUsers.php" enctype="multipart/form-data">
						<input type="submit" name="showProducts" value="Show all users" />
						</form>
						<form method="post" action="addUpdateUsers.php" enctype="multipart/form-data">
						<input type="submit" name="addProducts" value="Add or update a user" />
						</form>
						<form method="post" action="deleteUser.php" enctype="multipart/form-data">
						<input type="submit" name="deleteUser" value="Delete a user" />
						</form>
						';
						echo $logoff;
					}	
					
					// Populates the HTML for a manager.
					function populateForManager(){
						global $defaultForm;
						global $addModifyUserForm;
						global $logoff;
						echo $defaultForm;	
						echo $addModifyUserForm;
						echo $logoff;
					}
					
					// Populates the HTML for a user.
					function populateForUser(){
						global $defaultForm;
						global $logoff;
						echo $defaultForm;	
						echo $logoff;
					}
				?> 
			</div>
		</div>
	</body> 
</html>