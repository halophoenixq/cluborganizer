<?php
// Connect to server
include('connect.php');

$table_name="EVENT"; // Table name

$url = "editEvent.php";

include('dbGrabEvent.php');

//Build query
$query="UPDATE $db_name.$table_name SET EVENT_TYPE_ID = '$event_type', NAME = '$event_name', DESCRIPTION = '$description', START_DATE = '$start_date', START_TIME = '$start_time', END_TIME = '$end_time', LOCATION = '$location' WHERE EVENT_ID = $event_id";
echo $query;
echo "<br>";
if (!mysqli_query($con,$query)){
  die('Error: ' . mysqli_error($con));
  header('Location: ' . $url . "?success=1");
}
else{
	header('Location: ' . $url . "?success=0");
}
mysqli_close($con);
?>