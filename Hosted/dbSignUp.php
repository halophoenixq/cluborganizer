<?php
// Connect to server
include('connect.php');

$table_name="SIGNUP"; // Table name
$url = reset((explode('?', $_SERVER['HTTP_REFERER']))); //get rid of queries

$member_id = mysqli_escape_string($con, $_POST['member_id']);
$event_id = mysqli_escape_string($con, $_POST['event_id']);
$continue= true;

//Check if exists
$query="SELECT * FROM $db_name.$table_name WHERE EVENT_ID='$event_id' AND MEMBER_ID='$member_id'";
$result = mysqli_query($con, $query);
if(mysqli_num_rows($result) >= 1){
	$continue = false;
	header('Location: ' . $url . "?success=2");
}
if($continue== true){
//Build query
	$query="INSERT INTO $db_name.$table_name(EVENT_ID, MEMBER_ID)";
	$query.=" VALUES ('$event_id', '$member_id')";
	echo $query;
	echo "<br>";
	if (!mysqli_query($con,$query)){
		die('Error: ' . mysqli_error($con));
		header('Location: ' . $url . "?success=1");
	}
	else{
		header('Location: ' . $url . "?success=0");
	}
}
mysqli_close($con);
?>