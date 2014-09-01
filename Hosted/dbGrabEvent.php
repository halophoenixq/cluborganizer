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
$arr = explode('/', mysqli_real_escape_string($con, $_POST['start_date']));
$start_date= $arr[2] . $arr[0] . $arr[1];

// start time
$st_hour = explode(':', mysqli_real_escape_string($con, $_POST['start_time']));
$st_min = explode(' ', $st_hour[1]);
if($st_min[1]=="PM"){
	$st_hour[0] = $st_hour[0] + 12;
}
if($st_hour[0]<10){
	$st_hour[0] = "0" . $st_hour[0];
}
if($st_min[0]<10){
	$st_min[0] = "0" . $st_min[0];
}
$start_time = "";
$start_time .= $st_hour[0] . ":" . $st_min[0] . ":00";

// end time
$et_hour = explode(':', mysqli_real_escape_string($con, $_POST['end_time']));
$et_min = explode(' ', $et_hour[1]);
if($et_min[1]=="PM"){
	$et_hour[0] = $et_hour[0] + 12;
}
if($et_hour[0]<10){
	$et_hour[0] = "0" . $et_hour[0];
}
if($et_min[0]<10){
	$et_min[0] = "0" . $et_min[0];
}
$end_time = "";
$end_time .= $et_hour[0] . ":" . $et_min[0] . ":00";
?>