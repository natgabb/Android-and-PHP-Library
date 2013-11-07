<?php
	require_once('database_connect.php');
		
	if(!$db_server)
		die ("Could not connect to the database: " . mysql_error() . "<br/>");
		
	@mysql_select_db($db_schema)
		or die ("Unable to select database: " . mysql_error() . "<br/>");
		
	/*
	* Adds a product to the product table.
	*/
	function addProduct($p_quantity, $p_genre, $p_platform, $p_productname, $p_image, $p_description, $p_price, $p_taxable){
		global $db_server;
		
		// Escapes for illegal characters and SQL injections
		$quantity = mysql_real_escape_string($p_quantity);
		$platform = mysql_real_escape_string($p_platform);
		$genre = mysql_real_escape_string($p_genre);
		$product = mysql_real_escape_string($p_productname);
		$image = mysql_real_escape_string($p_image);
		$description = mysql_real_escape_string($p_description);
		$price = mysql_real_escape_string($p_price);
		$taxable = mysql_real_escape_string($p_taxable);
		
		$insert_query = "INSERT INTO product(quantity, platform, genre, name, image, description, price, taxable, createdate, modifydate) "
						. "VALUES ( $quantity, '$platform', '$genre', '$product', '$image', '$description', $price, $taxable, NOW(), NOW());";						
		mysql_query($insert_query);
		
		if(mysql_affected_rows() == 0)
			echo "An error was encountered while adding the product: " . mysql_error() . "<br/>";
		else
			echo "Product added.<br/>";			
	}
		
	/*
	* Deletes a product from the product table.
	*/
	function deleteProduct($p_product_id){
		global $db_server;
		
		// Escapes for illegal characters and SQL injections
		$id = mysql_real_escape_string($p_product_id);
		
		$deleteQuery = "DELETE FROM product WHERE _id = $id";
		mysql_query($deleteQuery);
		
		if(mysql_affected_rows() == 0){
			echo "An error was encountered while deleting the product. Product id: $id.<br/>";
			echo "Verify that the product exists.<br/>";
		}
		else
			echo "Product deleted.<br/>";
	}
	
	/*
	* Updates a product from the product table.
	*/
	function updateProduct($p_product_id, $p_quantity, $p_genre, $p_platform, $p_productname, $p_image, $p_description, $p_price, $p_taxable){
		global $db_server;
		
		// Escapes for illegal characters and SQL injections
		$id = mysql_real_escape_string($p_product_id);
		$quantity = mysql_real_escape_string($p_quantity);
		$platform = mysql_real_escape_string($p_platform);
		$genre = mysql_real_escape_string($p_genre);
		$product = mysql_real_escape_string($p_productname);
		$image = mysql_real_escape_string($p_image);
		$description = mysql_real_escape_string($p_description);
		$price = mysql_real_escape_string($p_price);
		$taxable = mysql_real_escape_string($p_taxable);
		
		$update_query = "UPDATE product SET quantity = $quantity, platform = '$platform', genre = '$genre', name = '$product', image = '$image', "
						. "description = '$description', price = $price, taxable = $taxable, modifydate = NOW() WHERE _id = $id";		
		mysql_query($update_query);
		
		if(mysql_affected_rows() == 0){
			echo "An error was encountered while updating the product. Product id: $id.<br/>";
			echo "Verify that the product exists.<br/>";
		}
		else
			echo "Product updated.<br/>";
	}
	
	/*
	* Returns a product from the product table. The user has to verify that the result set contains a product.
	*/
	function viewProduct($p_product_id){
		// Escapes for illegal characters and SQL injections
		$id = mysql_real_escape_string($p_product_id);
		
		$selectQuery = "SELECT * FROM product WHERE _id = $id";
		$result = mysql_query($selectQuery);
		
		if(!$result){
			echo "An error occured while retrieving the product.<br/>";
			echo mysql_error();
		}
		
		return $result;
	}
	
	/*
	* Returns a resultset containing all of the products in the database.
	*/
	function viewAllProducts(){
		$selectQuery = "SELECT * FROM product";
		$result = mysql_query($selectQuery);
		
		if(!$result){
			echo "An error occured while retrieving the product.<br/>";
			echo mysql_error();
		}
		
		return $result;
	}
	
	/*
	* Closes the database connection.
	*/
	function closeConnection(){
		global $db_server;
		mysql_close($db_server);
	}
?>