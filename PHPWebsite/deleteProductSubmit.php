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
					echo "<h1>Deleting a product</h1>";
					$id = strip_tags($_POST['id']);
					
					if(!empty($id)){
						require_once('maintain_products.php');
						deleteProduct($id);
					}else
						echo 'Please go back and make sure to fill out all the fields.';
					echo '<br /><br /><a href="deleteProduct.php">Go back</a>';
				}else
					echo "You do not have the permissions to do that.";
			}
			else
				echo 'Please <a href="index.html">login</a>.';
		?> 
	</div>
	</body> 
</html>