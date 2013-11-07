<html>
	<head>
		<title>Logging off</title>
	<link type="text/css" rel="Stylesheet" href="stylesheet.css" />
	</head>
	<body>
		<div id="contentDiv">
			<?php
				session_start();
				$_SESSION = array();
				session_destroy();
				echo '<h1>Logged off</h1>Good bye! <br /><br /> <a href="index.html">Go back to login page.</a>';
			?> 
		</div>
	</body> 
</html>