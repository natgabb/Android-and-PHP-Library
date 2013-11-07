<html>
	<head>
		<title>Show products</title>
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
					echo "<h1>Add or update a product</h1>";
					// Display form to add/update products.
					echo '
					<form method="post" action="addUpdateProductsSubmit.php" enctype="multipart/form-data">
						<label>Product ID:&nbsp;&nbsp;<input type="text" name="id" /></label><br />
						<label>Quantity:&nbsp;&nbsp;<input type="text" name="quantity" /></label><br />
						<label>Genre:&nbsp;&nbsp;<input type="text" name="genre" /></label><br />
						<label>Platform:&nbsp;&nbsp;<input type="text" name="platform" /></label><br />
						<label>Name:&nbsp;&nbsp;<input type="text" name="name" /></label><br />
						<label>Image:&nbsp;&nbsp;<input type="text" name="image" /></label><br />
						<label>Description:&nbsp;&nbsp;<input type="text" name="description" /></label><br />
						<label>Price:&nbsp;&nbsp;<input type="text" name="price" /></label><br />
						<label>Taxable:&nbsp;&nbsp;<input type="checkbox" name="taxable" /></label><br />
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