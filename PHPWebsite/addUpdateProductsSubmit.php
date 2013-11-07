<html>
	<head>
		<title>Add Products</title>
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
					echo "<h1>Adding/Updating a product</h1>";
					$id = strip_tags($_POST['id']);
					$quantity = strip_tags($_POST['quantity']);
					$genre = strip_tags($_POST['genre']);
					$platform = strip_tags($_POST['platform']);
					$name = strip_tags($_POST['name']);
					$image = strip_tags($_POST['image']);
					$description = strip_tags($_POST['description']);
					$price = strip_tags($_POST['price']);
					if(isset($_POST['$taxable']))
						$taxable = 1;
					else
						$taxable = 0;
					
					if(!empty($id) && !empty($quantity)
					&& !empty($genre) && !empty($platform) && !empty($name)
					&& !empty($image) && !empty($description) && !empty($price)){
						require_once('maintain_products.php');
						$result = viewProduct($id);
						$rows = mysql_num_rows($result);
						if($rows > 0){
							// This product exists, therefore you need to update.
							updateProduct($id, $quantity, $genre, $platform, $name, $image, $description, $price, $taxable);
						}
						else{
						// This is a new product.
							addProduct($quantity, $genre, $platform, $name, $image, $description, $price, $taxable);
						}
					}else
						echo 'Please go back and make sure to fill out all the fields.';
					echo '<br /><br /><a href="addUpdateProducts.php">Go back</a>';
				}else
					echo "You do not have the permissions to do that.";
			}
			else
				echo 'Please <a href="index.html">login</a>.';
		?> 
	</div>
	</body> 
</html>