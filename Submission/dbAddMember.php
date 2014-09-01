<?php
// Connect to server
include('connect.php');

$db_name="core"; // Database name
$table_name="member"; // Table name
$url = reset((explode('?', $_SERVER['HTTP_REFERER']))); //get rid of queries

include('dbGrabMember.php');

//Build query
$query="INSERT INTO $db_name.$table_name(USERNAME, PASSWORD, MAJOR_ID, FIRST_NAME, LAST_NAME, PHONE, EMAIL, GRAD_YEAR, CLASS_STAND_ID, ACTIVE, CLASS_ID, RANK_ID, COMMENTS, JOIN_DATE)";
$query.=" VALUES ('$USERNAME', '$PASSWORD', '$MAJOR', '$FNAME', '$LNAME', '$PHONE', '$EMAIL', '$GRAD_YEAR', '$CLASS_STAND', '1', '1', '1', '$COMMENTS' ,'$JOIN_DATE')";
echo $query;
echo "<br>";
if (!mysqli_query($con,$query)){
	die('Error: ' . mysqli_error($con));
	header('Location: ' . $url . "?success=1");
}
else{
	if(isset($_POST['prospective'])){
		$prospective_id = mysqli_escape_string($con, $_POST['prospective']);
		$query="UPDATE CORE.PROSPECTIVE SET ACTIVE='0' WHERE PROSPECTIVE.MEMBER_ID = '$prospective_id'";	
		mysqli_query($con,$query) or die('Error: ' . mysqli_error($con));
	}
	
	header('Location: ' . $url . "?success=0");
}
mysqli_close($con);
?>