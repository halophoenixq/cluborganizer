<?php
include('connect.php');

$subject=mysqli_escape_string($con, $_POST['subject']);
$message=mysqli_escape_string($con, $_POST['message']);

// $query="SELECT email ";
// $query.= "FROM CORE.MEMBER";
// $result=mysqli_query($con, $query) or die("Query failed.");
// $to="";
// while($row=mysqli_fetch_array($result)){
// 	$to.= $row['email'] . ", ";
// };
$to="qhsu@usc.edu";

require 'mailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
$mail->SMTPDebug = 1;
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
$mail->Mailer = 'smtp';
$mail->Port = 587;
$mail->Username = 'uscaptclub@gmail.com';                            // SMTP username
$mail->Password = '';                           // SMTP password

$mail->From = 'uscaptclub@gmail.com';
$mail->FromName = 'USC APT';
$mail->addAddress($to);  // Add a recipient

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $subject;
$mail->Body    = $message;

if(!$mail->send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   header('Location:sendEmail.php?success=1');
   exit;
}
else{
	header('Location:sendEmail.php?success=0');
}
?>