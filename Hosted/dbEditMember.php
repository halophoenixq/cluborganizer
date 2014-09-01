<?php
// Connect to server
include('connect.php');

$table_name="MEMBER"; // Table name
$url = "editMember.php";

include('dbGrabMember.php');

//Build query
$query="UPDATE $db_name.$table_name SET FIRST_NAME='$FNAME', LAST_NAME='$LNAME', USERNAME= '$USERNAME', PHONE='$PHONE', EMAIL='$EMAIL', MAJOR_ID='$MAJOR', GRAD_YEAR='$GRAD_YEAR', CLASS_STAND_ID='$CLASS_STAND', ACTIVE='$ACTIVE', CLASS_ID='$CLASS', RANK_ID='$RANK', JOIN_DATE='$JOIN_DATE'";
$query.=" WHERE MEMBER_ID=$MEMBER_ID";
echo $query;
echo "<br>";
if (!mysqli_query($con,$query))
{
	die('Error: ' . mysqli_error($con));
	header('Location: ' . $url . "?success=1");
}
else{
	header('Location: ' . $url . "?success=0");
}
?>