<?php
	require_once('saltpassword.php');
	$password = "password";
	echo("Password: $password<br /><br />");
	$saltedPass = saltPassword($password);
	echo("Salted Password: $saltedPass");
?>