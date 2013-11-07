<html>
	<head>
		<title>Show Products</title>
		<link type="text/css" rel="Stylesheet" href="stylesheet.css" />
	</head>
	<body>
	<div id="contentDiv">
		<?php 
			session_start();
			if(isset($_SESSION['status'])){
				$status = $_SESSION['status'];
					if($status == 0 || $status == 1 || $status == 2){
						require_once('maintain_products.php');
						
						$result = viewAllProducts();
						if($result){
							$rows = mysql_num_rows($result);
							echo "<h1>$rows products</h1>";
							if($rows != 0){
								for($j = 0; $j < $rows; $j++){
									$row = mysql_fetch_assoc($result);
									printOneProduct($row);
								}
							}
							echo '<br /><br /><a href="login_check.php">Go back</a>';
						}
					}
					else
						echo 'You do not have the permissions to do that.<br /><br /><a href="login_check.php">Go back</a>';
			}
			else
				echo 'Please <a href="index.html">login</a>.';
				
			// Prints one product.	
			function printOneProduct($productRow)
			{
				echo '<h2>ID: ' . $productRow['_id'] . '</h2><br />';
				echo '<img class="productImg" align="left" src="' . $productRow['Image'] . '" />';
				echo 'Quantity: ' . $productRow['Quantity'] . '<br />';
				echo 'Genre: ' . $productRow['Genre'] . '<br />';
				echo 'Platform: ' . $productRow['Platform'] . '<br />';
				echo 'Name: ' . $productRow['Name'] . '<br />';
				echo 'Description: ' . $productRow['Description'] . '<br />';
				echo 'Price: ' . $productRow['Price'] . '<br />';
				echo 'Taxable: ' . $productRow['Taxable'] . '<br />';
				echo 'CreateDate: ' . $productRow['CreateDate'] . '<br />';
				echo 'ModifyDate: ' . $productRow['ModifyDate'] . '<br /><br />';
			}
		?> 
	</div>
	</body> 
</html>