<html lang="en">

<head>
	<title>Welcome to APT!</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/phil/normalize.css" type="text/css" media="screen">
	<link rel="stylesheet" href="css/phil/grid.css" type="text/css" media="screen">
	<link rel="stylesheet" href="css/phil/style.css" type="text/css" media="screen">
	
	<script type='text/javascript' src='js/jquery.min.js'></script>

	<script type="text/javascript" src="js/phil/jquery.stellar.min.js"></script>
	<script type="text/javascript" src="js/phil/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/phil/waypoints.min.js"></script>

	<script type="text/javascript" src="js/phil/jquery.slides.min.js"></script>
	<!-- // <script type="text/javascript" src="js/phil/galleria-1.3.5.min.js"></script> -->
	<script type="text/javascript" src="js/phil/scripts.js"></script>
	
	<!-- Start SlidesJS Optional-->
	<style>
		body {
			-webkit-font-smoothing: antialiased;
			color: #232525;
			padding-top:70px;"
		}
		#slides {
			display: none
		}
		#slides .slidesjs-navigation {
			margin-top:5px;
		}
		a.slidesjs-next,
		a.slidesjs-previous,
		a.slidesjs-play,
		a.slidesjs-stop {
			background-image: url(images/btns-next-prev.png);
			background-repeat: no-repeat;
			display:block;
			width:12px;
			height:18px;
			overflow: hidden;
			text-indent: -9999px;
			float: left;
			margin-right:5px;
		}
		a.slidesjs-next {
			margin-right:10px;
			background-position: -12px 0;
		}
		a:hover.slidesjs-next {
			background-position: -12px -18px;
		}
		a.slidesjs-previous {
			background-position: 0 0;
		}
		a:hover.slidesjs-previous {
			background-position: 0 -18px;
		}
		a.slidesjs-play {
			width:15px;
			background-position: -25px 0;
		}
		a:hover.slidesjs-play {
			background-position: -25px -18px;
		}
		a.slidesjs-stop {
			width:18px;
			background-position: -41px 0;
		}
		a:hover.slidesjs-stop {
			background-position: -41px -18px;
		}
		.slidesjs-pagination {
			margin: 7px 0 0;
			float: right;
			list-style: none;
		}
		.slidesjs-pagination li {
			float: left;
			margin: 0 1px;
		}
		.slidesjs-pagination li a {
			display: block;
			width: 13px;
			height: 0;
			padding-top: 13px;
			background-image: url(images/pagination.png);
			background-position: 0 0;
			float: left;
			overflow: hidden;
		}
		.slidesjs-pagination li a.active,
		.slidesjs-pagination li a:hover.active {
			background-position: 0 -13px
		}
		.slidesjs-pagination li a:hover {
			background-position: 0 -26px
		}
		#slides a:link,
		#slides a:visited {
			color: #333
		}
		#slides a:hover,
		#slides a:active {
			color: #9e2020
		}
		.navbar {
			overflow: hidden
		}
	</style>
	<!-- End SlidesJS Optional-->

	<!-- SlidesJS Required: These styles are required if you'd like a responsive slideshow -->
	<style>
		#slides {
			display: none
		}
		.container {
			margin: 0 auto;
		}
		/* For tablets & smart phones */
		@media (max-width: 767px) {
			body {
				padding-left: 20px;
				padding-right: 20px;
			}
			.container {
				width: auto
			}
		}
		/* For smartphones */
		@media (max-width: 480px) {
			.container {
				width: auto
			}
		}
		/* For smaller displays like laptops */
		@media (min-width: 768px) and (max-width: 979px) {
			.container {
				width: 724px
			}
		}
		/* For larger displays */
		@media (min-width: 1200px) {
			.container {
				width: 1170px
			}
		}
		.imagecontainer{
			position: relative;
		}
		/*Change this for altering hover text over events*/
		.date{
			font-size: 17pt;
			/*font-weight: bold;*/
			color:white;
			background:#333;
			text-shadow:    -1px -1px 0 #333,    1px -1px 0 #333,    -1px 1px 0 #333,    1px 1px 0 #333; 
			text-align: center;
			position: absolute;
			top:0%;
			height:100%;
			width: 100%;
			padding-top: 4px;
			padding-right: 4px;
			padding-left: 4px;
			opacity: 0;
		}
	</style>

	<!-- SlidesJS Required: -->
	<script>
		$(function() {
			$('#slides').slidesjs({
				width: 940,
				height: 528,
				play: {
					active: true,
					auto: true,
					interval: 6000,
					swap: true
				}
			});
		});
	</script>

	<!-- Event Picture Management -->
	<script type="text/javascript">
		$(document).ready(function(){
			$('.imagecontainer').on("mouseenter", function(){
				$(this).find(".date").animate({"opacity":".85"});
			});
			$('.imagecontainer').on("mouseleave", function(){
				$(this).find(".date").animate({"opacity":"0"});
			});
		});
	</script>

	<!-- Query for form-->
	<?php
	include('connect.php');

  	// populate event type
	$query="SELECT * FROM CLASS_STANDING";
	$result= mysqli_query($con, $query) or die("Query failed.");
	$class_stand_opt = "";
	while($row=mysqli_fetch_array($result)) {
		$class_stand_opt .= "<option value={$row['CLASS_STAND_ID']}>{$row['NAME']}</option>\n";
	}
	?>

	<!-- Query for event images for slide 3 -->
	<?php 
	include('connect.php');
	//find photos for upcoming 4 events
	$query = "SELECT PHOTO_ID, path, PHOTO.NAME AS pname, EVENT.EVENT_ID AS eid, EVENT.NAME AS ename, EVENT.DESCRIPTION AS DESCRIPT, EVENT_TYPE.NAME AS etype, LOCATION, DATE_FORMAT(START_DATE,'%M %d, %Y') AS sdate, DATE_FORMAT(START_TIME,'%h:%i %p') AS stime, DATE_FORMAT(END_TIME,'%h:%i %p') AS etime  ";
	$query .= "FROM PHOTO LEFT JOIN PHOTO_TYPE ON PHOTO.PHOTO_TYPE_ID = PHOTO_TYPE.PHOTO_TYPE_ID LEFT JOIN EVENT ON PHOTO.EVENT_ID = EVENT.EVENT_ID LEFT JOIN EVENT_TYPE ON EVENT.EVENT_TYPE_ID = EVENT_TYPE.EVENT_TYPE_ID ";
	$query .= "WHERE ADDTIME( START_DATE, START_TIME ) > NOW( ) ";
	$query .= "ORDER BY START_DATE, START_TIME ";	
	$query .= "LIMIT 4";
	$result= mysqli_query($con, $query) or die("Query failed." . mysqli_error($con));
	$photo_opt = "";
	while($row=mysqli_fetch_array($result)) {
		$photo_opt .= "<div class='imagecontainer'><img class='gallery_pic' src={$row['path']} alt={$row['pname']}>\n
		<span class='date'>
			{$row['ename']}<br>
			{$row['sdate']}<br>{$row['stime']} - {$row['etime']}<br>
			{$row['LOCATION']}<hr>{$row['DESCRIPT']}
		</span>\n
	</div>\n";
}

	// populate major
$query="SELECT * FROM MAJOR ORDER BY MAJOR.NAME";
$result= mysqli_query($con, $query) or die("Query failed.");
$major_opt = "";
while($row=mysqli_fetch_array($result)) {
	$major_opt .= "<option value={$row['MAJOR_ID']}";
	$major_opt .= ">{$row['NAME']}</option>\n";
}
?>
</head>

<body>
	<!-- NavBar -->
	<div class="menu">
		<div class="container clearfix">
			<div id="logo" class="grid_3">
				<img src="images/apt_web.png">
			</div>
			<div id="nav" class="grid_9 omega">
				<ul class="navigation">
					<li data-slide="1">Home</li>
					<li data-slide="2">About</li>
					<li data-slide="3">Events</li>
					<li data-slide="4">Register</li>
					<li data-slide="5">Members</li>
					<li data-slide="6">Admin</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="slide" id="slide1" data-slide="1" data-stellar-background-ratio="0.5">
		<div class="container clearfix">
			<div id="about" class="grid_12">
				<h1>Advanced Persistent Threat</h1><br>
				<h2>A security club at the University of Southern California.</h2><br>
				<p>Through a variety of hands-on events, we examine and work with all aspects of computer, network, information and physical security in order to help members gain a heightened understanding of technology and its security applications.
				</p>
				<br>
			</div>
		</div>
	</div>

	<div class="slide" id="slide2" data-slide="2" data-stellar-background-ratio="0.5">
		<div class="container clearfix">
			<div id="benefit" class="grid_12">
				<h2>Take a Look at Some of the Benefits of Joining APT</h2>
			</div>
			<div id="lab" class="grid_6">
				<div style="padding: 5px;">
					<div>
						<img src="images/lab.png" width="20" style="float:left;padding-right:8px" />
						<h3>Hands-on Labs:</h3>
					</div>
					<div id="description">Our weekly meetings are attached to small lab sessions, where members will get to experiment with specific security tools and software in a controlled classroom setting.</div>
				</div>
			</div>
			<div id="lecture" class="grid_6 omega">
				<div style="padding: 5px;">
					<div>
						<img src="images/lecture.png" width="20" style="float:left;padding-right:8px" />
						<h3>Security Lectures:</h3>
					</div>
					<div id="description">Each club meeting will feature a lecture on a specific security topic. From advanced networking to password cracking and lock picking, we’ll cover all aspects of security through these in-depth tutorials.</div>
				</div>
			</div>
			<div id="competition" class="grid_6">
				<div style="padding: 5px;">
					<div>
						<img src="images/competition.png" width="20" style="float:left;padding-right:8px" />
						<h3>Competitions:</h3>
					</div>
					<div id="description">Each semester, we’ll be hosting a variety of fun competitions and games in an effort to allow member to exercise the skills we teach in a practical and time-constrained setting.</div>
				</div>
			</div>
			<div id="help" class="grid_6 omega">
				<div style="padding: 5px;">
					<div>
						<img src="images/help.png" width="20" style="float:left;padding-right:8px" />
						<h3>One-to-One Help:</h3>
					</div>
					<div id="description">We provide one-to-one help to all of our members during each club meeting to ensure they understand and are comfortable with the content we cover. After all, learning is more fun when you understand what you’re covering!</div>
				</div>
			</div>
		</div>
	</div>

	<div class="slide" id="slide3" data-slide="3" data-stellar-background-ratio="0.5">
		<div class="container clearfix">
			<h2>Events</h2>
			<div id="container" class="grid_12">
				<div id="slides">
					<?php print $photo_opt ?>
				</div>
			</div>
		</div>

	</div>

	<div class="slide" id="slide4" data-slide="4" data-stellar-background-ratio="0.5">
		<div class="container clearfix">
			<h2>Register</h2>
			<hr>
			<br>
          <!-- validation
          0 = success
          1 = query failure
          2 = invalid email
          3 = invalid phone
          4 = invalid grad year
      -->
      <?php
      if(!isset($_GET['success'])){

      }
      elseif($_GET['success']==0){
      	print "<p class='error'>Thank you for signing up!</p>";
      }
      elseif($_GET['success']==1){
      	print "<p class='error'>Error in registration, please try again.</p>";
      }
      elseif($_GET['success']==2){
      	print "<p class='error'>Error in email, please try again.</p>";
      }
      elseif($_GET['success']==3){
      	print "<p class='error'>Error in phone number, please try again.</p>";
      }
      elseif($_GET['success']==4){
      	print "<p class='error'>Error in grad year, please try again.</p>";
      }
      ?>
      <form class="form-horizontal" role="form" action="dbRegister.php" method="POST">

      	<!-- Member First Name -->
      	<div class="form-group">
      		<div class="col-sm-3"></div>
      		<label for="fname" class="col-sm-2 control-label">First Name</label>
      		<div class="col-sm-4">
      			<input type="text" class="form-control" placeholder="First Name" id="fname" name="fname" required>
      		</div>
      	</div>

      	<!-- Member Last Name -->
      	<div class="form-group">
      		<div class="col-sm-3"></div>
      		<label for="lname" class="col-sm-2 control-label">Last Name</label>
      		<div class="col-sm-4">
      			<input type="text" class="form-control" placeholder="Last Name" id="lname" name="lname" required>
      		</div>
      	</div>

      	<!-- Email -->
      	<div class="form-group">
      		<div class="col-sm-3"></div>
      		<label for="email" class="col-sm-2 control-label">Email</label>
      		<div class="col-sm-4">
      			<input type="email" class="form-control" placeholder="Email" id="email" name="email" required>
      		</div>
      	</div>

      	<!-- Phone -->
      	<div class="form-group">
      		<div class="col-sm-3"></div>
      		<label for="phone" class="col-sm-2 control-label">Phone</label>
      		<div class="col-sm-4">
      			<input type="tel" class="form-control" placeholder="Phone" id="phone" name="phone" required>
      		</div>
      	</div>

      	<!-- Class Standing -->
      	<div class="form-group">
      		<div class="col-sm-3"></div>
      		<label for="class_stand" class="col-sm-2 control-label">Class Standing</label>
      		<div class="col-sm-4">
      			<select class="form-control" name="class_stand" id="class_stand" required>
      				<?php print $class_stand_opt?>
      			</select>
      		</div>
      	</div>

      	<!-- Major -->
      	<div class="form-group">
      		<div class="col-sm-3"></div>
      		<label for="major" class="col-sm-2 control-label">Major</label>
      		<div class="col-sm-4">
      			<select class="form-control" name="major" id="major" required>
      				<?php print $major_opt?>
      			</select>
      		</div>
      	</div>

      	<!-- Grad Year -->
      	<div class="form-group">
      		<div class="col-sm-3"></div>
      		<label for="grad" class="col-sm-2 control-label">Graduation Year</label>
      		<div class="col-sm-4">
      			<input type="text" class="form-control" placeholder="Graduation Year" id="grad" name="grad" required>
      		</div>
      	</div>

      	<!-- Button -->
      	<div class="col-md-4"></div>
      	<div class="col-md-4">
      		<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
      	</div>
      </form>
  </div>
</div>
</body>

<footer id="footer">
	<div id="copyright" class="grid_8">
		<p>Copyright 2014 Advanced Persistent Threat Club, University of Southern California</p>
	</div>

	<div id="social" class="grid_4 omega">
		<ul>
			<li class="facebook"><a href="https://facebook.com/uscapt">Facebook</a></li>
			<li class="twitter"><a href="https://twitter.com/uscapt">Twitter</a></li>
		</ul>
	</div>
</footer>

</html>
