<?php
include('connect.php');

$username = $_POST['username'];
$pass = $_POST['password'];
$password = md5($pass);

$continue = true;
if(empty($username) || empty($pass)){
	header("Location:admin_login.php?loginFailed=true&reason=blank");
	$continue = false;
}

if($continue){
	$query = "SELECT * FROM $db_name.ADMIN WHERE username = '$username' AND password = '$password'";
	$result = mysqli_query($con, $query);
 	$num_results = mysqli_num_rows($result);

	if($num_results == 1){
		session_start();
		$_SESSION['admin'] = "1";
		header ("Location: portal.php");
	}
	else {
		header("Location:admin_login.php?loginFailed=true&reason=login");
	}
}
?>