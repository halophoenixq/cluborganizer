<?php
if(isset($_POST['event_id'])){
$event_id=mysqli_real_escape_string($con, $_POST['event_id']);
}
if(isset($_POST['event_type'])){
$event_type=mysqli_real_escape_string($con, $_POST['event_type']);
}
if(isset($_POST['event_name'])){
$event_name=mysqli_real_escape_string($con, $_POST['event_name']);
}
if(isset($_POST['location'])){
$location=mysqli_real_escape_string($con, $_POST['location']);
}
if(isset($_POST['description'])){
$description=mysqli_real_escape_string($con, $_POST['description']);
}
$start_date=datetime::createfromformat('m/d/Y', mysqli_real_escape_string($con, $_POST['start_date']));
$start_date=$start_date->format('Ymd');

// start time
$start_time_parse=date_parse_from_format('g:i A', mysqli_real_escape_string($con, $_POST['start_time']));
if($start_time_parse['hour']<10){
	$start_time_parse['hour'] = "0" . $start_time_parse['hour'];
}
if($start_time_parse['minute']<10){
	$start_time_parse['minute'] = "0" . $start_time_parse['minute'];
}
if($start_time_parse['second']<10){
	$start_time_parse['second'] = "0" . $start_time_parse['second'];
}
$start_time = "";
$start_time .= $start_time_parse['hour'] . ":" . $start_time_parse['minute'] . ":" . $start_time_parse['second'];

// end time
$end_time_parse=date_parse_from_format('g:i A', mysqli_real_escape_string($con, $_POST['end_time']));
if($end_time_parse['hour']<10){
	$end_time_parse['hour'] = "0" . $end_time_parse['hour'];
}
if($end_time_parse['minute']<10){
	$end_time_parse['minute'] = "0" . $end_time_parse['minute'];
}
if($end_time_parse['second']<10){
	$end_time_parse['second'] = "0" . $end_time_parse['second'];
}
$end_time = "";
$end_time .= $end_time_parse['hour'] . ":" . $end_time_parse['minute'] . ":" . $end_time_parse['second'];
?>