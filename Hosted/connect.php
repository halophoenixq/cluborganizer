<?php
	$host="mysql12.000webhost.com";
	$sql_username="a6277591_test";
	$sql_password="rawrrawr1";
	$con=mysqli_connect($host, $sql_username, $sql_password)
	or die('Could not connect: ' . mysql_error());
	$db_name="a6277591_test"; // Database name
	mysqli_select_db($con, $db_name);
?>