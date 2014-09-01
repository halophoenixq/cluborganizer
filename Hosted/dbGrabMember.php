<?php

if(isset($_POST['member_id'])){
	$MEMBER_ID = $_POST['member_id'];
}
//Grab user information
if(isset($_POST['username'])){
	$USERNAME=mysqli_escape_string($con, $_POST['username']);
}
if(isset($_POST['password'])){
	$PASSWORD=md5(mysqli_escape_string($con, $_POST['password']));
}
if(isset($_POST['fname'])){
	$FNAME=mysqli_escape_string($con, $_POST['fname']);
}
if(isset($_POST['lname'])){
	$LNAME=mysqli_escape_string($con, $_POST['lname']);
}
if(isset($_POST['email'])){
	$EMAIL=mysqli_escape_string($con, $_POST['email']);
}
if(isset($_POST['phone'])){
	$PHONE=mysqli_escape_string($con, $_POST['phone']);
}
if(isset($_POST['grad'])){
	$GRAD_YEAR=mysqli_escape_string($con, $_POST['grad']);
}
if(isset($_POST['class_stand'])){
	$CLASS_STAND=mysqli_escape_string($con, $_POST['class_stand']);
}
if(isset($_POST['active'])){
	$ACTIVE=1;
}
else{
	$ACTIVE=0;
}
if(isset($_POST['major'])){
	$MAJOR=mysqli_escape_string($con, $_POST['major']);
}
if(isset($_POST['class'])){
	$CLASS=mysqli_escape_string($con, $_POST['class']);
}
if(isset($_POST['rank'])){
	$RANK=mysqli_escape_string($con, $_POST['rank']);
}
if(isset($_POST['join_date'])){
	$arr = explode('/', mysqli_real_escape_string($con, $_POST['join_date']));
	$JOIN_DATE= $arr[2] . $arr[0] . $arr[1];
}
if(isset($_POST['comment'])){
	$COMMENTS=mysqli_escape_string($con, $_POST['comment']);
}
?>