<?php
include('connect.php');

$username = $_POST['username'];
$pass = $_POST['password'];
$password = md5($pass);

$continue = true;
if(empty($username) || empty($pass)){
	header("Location:member_login.php?loginFailed=true&reason=blank");
	$continue = false;
}

if($continue){
	$query = "SELECT * FROM core.member WHERE username = '$username' AND password = '$password'";
	$result = mysqli_query($con, $query);
 	$num_results = mysqli_num_rows($result);
 	$row=mysqli_fetch_array($result);

	if($num_results == 1){
		session_start();
		$id=$row['MEMBER_ID'];
		$_SESSION["member_id"] = $id;
		header ("Location: member.php");
	}
	else {
		header("Location:member_login.php?loginFailed=true&reason=login");
	}
}
?>