<?php
session_start();
session_destroy();
?>
<html lang="en">
<head>
	<title>Login</title><head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="css/phil/admin_login.css" type="text/css" media="screen">
	<script type='text/javascript' src='js/bootstrap.min.js'></script>

	<script>
		setTimeout("location.href = 'index.php';", 2000);
	</script>
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
						<h3 class="panel-title" style="text-align:center">Logout</h3>
					</div>
					<div class="panel-body">
						<form accept-charset="UTF-8" role="form" action="index.php">
							<fieldset>
								<h4 style="text-align:center;">You have successfully logged out!</h4>
								<input class="btn btn-lg btn-success btn-block" type="submit" value="Return">
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>