<html>
	<head>
		<title>Delete a Product</title>
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
					echo "<h1>Delete a Product</h1>";
					// Display form to delete a product
					echo '
					<p>Warning, this cannot be undone.</p>
					<form method="post" action="deleteProductSubmit.php" enctype="multipart/form-data">
						<label>Product ID of product to be deleted:&nbsp;&nbsp;<input type="text" name="id" /></label><br />
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