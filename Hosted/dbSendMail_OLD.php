<?php
include('connect.php');

$subject=mysqli_escape_string($con, $_POST['subject']);
$message=mysqli_escape_string($con, $_POST['message']);

$query="SELECT email ";
$query.= "FROM CORE.MEMBER";
$result=mysqli_query($con, $query) or die("Query failed.");
$to="";
while($row=mysqli_fetch_array($result)){
	$to.= $row['email'] . ", ";
};

if(mail($to, $subject, $message)){
	header('Location:sendEmail.php?success=0');
}
else{
	header('Location:sendEmail.php?success=1');
}
?>