<?php
// Connect to server
include('connect.php');

$db_name="core"; // Database name
$table_name="prospective"; // Table name
$url = reset((explode('?', $_SERVER['HTTP_REFERER']))); //get rid of queries

if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)){ //Email check
	header('Location: ' . $url . "?success=2");
}
//eliminate every char except 0-9
$justNums = preg_replace("/[^0-9]/", '', $PHONE);
//eliminate leading 1 if its there
if (strlen($justNums) == 11) $justNums = preg_replace("/^1/", '',$justNums);
//if we have 10 digits left, it's probably valid.
if (strlen($justNums) == 10) $isPhoneNum = true;

if(!$isPhoneNum){ //Phone check
	header('Location: ' . $url . "?success=3");
}
if(!preg_match("/^\d{4}$/", $GRAD_YEAR)){ //Grad year check
	header('Location: ' . $url . "?success=4");
}

include('dbGrabMember.php');

//Build query
$query="INSERT INTO $db_name.$table_name(FIRST_NAME, LAST_NAME, PHONE, EMAIL, MAJOR_ID, GRAD_YEAR, CLASS_STAND_ID, ACTIVE)";
$query.=" VALUES ('$FNAME', '$LNAME', '$PHONE', '$EMAIL', '$MAJOR', '$GRAD_YEAR', '$CLASS_STAND', '1')";
echo $query;
echo "<br>";
if (!mysqli_query($con,$query)){
	die('Error: ' . mysqli_error($con));
	header('Location: ' . $url . "?success=1#slide4");
}
else{
	header('Location: ' . $url . "?success=0#slide4");
}
mysqli_close($con);
?>