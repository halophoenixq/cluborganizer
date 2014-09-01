<?php
session_start();
if(isset($_SESSION['admin'])){
	header("Location:portal.php");
}
?>
<html lang="en">
<head>
	<title>Login</title><head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="css/phil/admin_login.css" type="text/css" media="screen">
	<script type='text/javascript' src='js/bootstrap.min.js'></script>
</head>


<body>
	<div id="title">
		<h1>Advanced Persistent Threat</h1>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title" style="text-align:center">Administrator Login</h3>
					</div>
					<div class="panel-body">
						<form accept-charset="UTF-8" role="form" action="admin_login_verify.php" method="POST">
							<fieldset>
								<div class="form-group">
									<input class="form-control" placeholder="Username" name="username" type="text" required autofocus>
								</div>
								<div class="form-group">
									<input class="form-control" placeholder="Password" name="password" type="password" required>
								</div>
								<input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
							</fieldset>
						</form>
					</div>
					<?php 
					$reasons = array("login" => "Wrong Username or Password", "blank" => "You have left one or more fields blank.",
					  "2" => "2."); 
					if (isset($_GET["loginFailed"]))
						echo $reasons[$_GET["reason"]]; 
					?>
				</div>
				<script>
					function goBack()
					{
						window.location.href = 'index.php';
					}
				</script>
				<div style="text-align:center;">
				<button type = "button" class="btn btn-default btn-lg" onclick="goBack()"><span class="glyphicon glyphicon-circle-arrow-left"></span>  Go Back</button>
				</div>
			</div>
		</div>
	</div>
</body>
</html>