<?php
// Connect to server
include('connect.php');

$table_name="EVENT"; // Table name
$url = reset((explode('?', $_SERVER['HTTP_REFERER']))); //get rid of queries
$continue=true;

include('dbGrabEvent.php');

// delete related signups
$query="DELETE FROM signup WHERE signup.event_id='$event_id'";
if (!mysqli_query($con,$query)){
	die('Error: ' . mysqli_error($con));
	header('Location: ' . $url . "?success=2");
	$continue=false;
}

if($continue){
// delete related signins
	$query="DELETE FROM signin WHERE signin.event_id='$event_id'";
	if (!mysqli_query($con,$query)){
		die('Error: ' . mysqli_error($con));
		header('Location: ' . $url . "?success=2");
		$continue=false;
	}
}

if($continue){
// delete related photos
	$query="DELETE FROM photo WHERE photo.event_id='$event_id'";
	if (!mysqli_query($con,$query)){
		die('Error: ' . mysqli_error($con));
		header('Location: ' . $url . "?success=2");
		$continue=false;
	}

}

if($continue){
	$query="DELETE FROM $db_name.$table_name WHERE event_id='$event_id'";
	echo $query;
	echo "<br>";
	if (!mysqli_query($con,$query)){
		die('Error: ' . mysqli_error($con));
		header('Location: ' . $url . "?success=2");
	}
	else{ //Success, so go back to all events page
		header('Location: editEvent.php');
	}
}
mysqli_close($con);
?>