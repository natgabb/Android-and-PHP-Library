<?php
/**
* Accepts a password and returns a md5 hex value for the password.
*/
function saltPassword($password){
	$salt1 = "qm&h*";
	$salt2 = "pg!@";
	
	return md5("$salt1$password$salt2");
}
?>