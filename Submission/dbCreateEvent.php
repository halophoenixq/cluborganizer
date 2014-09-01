<?php
// Connect to server
include('connect.php');

$db_name="core"; // Database name
$table_name="event"; // Table name
$url = reset((explode('?', $_SERVER['HTTP_REFERER']))); //get rid of queries

include('dbGrabEvent.php');
// Validation


// if($_POST['start_time_pm'] == 'pm'){
// 	$_POST['start_time_h'] += 12;
// }
// $start_time="" . $_POST['start_time_h'] . ":" . $_POST['start_time_m'] .":00";

// if($_POST['end_time_pm'] == 'pm'){
// 	$_POST['end_time_h'] += 12;
// }
// $end_time="" . $_POST['end_time_h'] . ":" . $_POST['end_time_m'] .":00";

//Build query
// $query="INSERT INTO $db_name.$table_name(EVENT_TYPE_ID, NAME, DESCRIPTION, START_DATE, END_DATE, START_TIME, END_TIME)";
// $query.=" VALUES ('$event_type', '$name', '$description', CONVERT(datetime,'$start_date',101), '$end_date', '$start_time', '$end_time')";
$query="INSERT INTO $db_name.$table_name(EVENT_TYPE_ID, NAME, DESCRIPTION, START_DATE, START_TIME, END_TIME, LOCATION)";
$query.=" VALUES ('$event_type', '$event_name', '$description', '$start_date', '$start_time', '$end_time', '$location')";
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