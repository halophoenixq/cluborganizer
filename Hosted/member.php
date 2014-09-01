<?php
session_start();
if(!isset($_SESSION['member_id'])){
	header("Location:member_login.php?loginFailed=true&reason=login");
}
?>

<html lang="en">
<head>
	<title>Member Area</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="css/phil/admin_login.css" type="text/css" media="screen">
	<script type='text/javascript' src='js/bootstrap.min.js'></script>

	<!-- Queries -->
	<?php
	include('connect.php');
	$member_id=$_SESSION['member_id'];
	// find name
	$query = "SELECT first_name, last_name FROM MEMBER WHERE member_id=$member_id";
	$result = mysqli_query($con, $query);
	$member_row = mysqli_fetch_array($result);

  	// all events
	$query = "SELECT event_id, EVENT.name AS ename, EVENT_TYPE.name AS etype, location, DATE_FORMAT(start_date,'%c/%d/%Y') AS sdate, DATE_FORMAT(start_time,'%h:%i %p') AS stime ";
	$query .= "FROM EVENT LEFT JOIN EVENT_TYPE ON EVENT.event_type_id = EVENT_TYPE.event_type_id ";
  	//search part
	if(isset($_POST['search'])){
		$term = mysqli_escape_string($con, $_POST['search']);
		$query .= "WHERE EVENT.name LIKE '%$term%' ";
	}
	if(isset($_GET['sorte'])){
		$sorte = $_GET['sorte'];
		str_replace("'", "", $sorte);
		echo $sorte;
		$query .= "ORDER BY $sorte";
	}
	else{
		$query .= "ORDER BY start_date DESC, start_time DESC";
	}


	$result = mysqli_query($con, $query) or die("Query failed." . mysqli_error($con));

	$upevents = "";

	while($row = mysqli_fetch_array($result)){
		$upevents .= "<tr data-id={$row['event_id']} onclick='submit(this)'>";
		$upevents .= "<td>{$row['event_id']}</td>";
		$upevents .= "<td>{$row['ename']}</td>";
		$upevents .= "<td>{$row['etype']}</td>";
		$upevents .= "<td>{$row['location']}</td>";
		$upevents .= "<td>{$row['sdate']}</td>";
		$upevents .= "<td>{$row['stime']}</td>";
		$upevents .= "</tr>\n";
	}
	?>

	<!-- Click Script -->
	<script type="text/javascript">
		function submit(tableRow) {
      //get ID
      var myID = tableRow.dataset.id;

      document.getElementById('event_id').value = myID;
      
      //submit
      var form = document.getElementById('event_more');
      form.submit();
  };    
</script>
</head>


<body>
	<!-- Top Navbar -->
	<div class="navbar navbar-inverse " role="navigation">
		<div class="container-fluid">
			<!-- Responsive Navbar -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar">Main Site</span>
					<span class="icon-bar">Logout</span>
				</button>
				<a class="navbar-brand" href="member.php">Member Area</a>
			</div>
			<!-- Navbar Items -->
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="">Welcome <?php print $member_row['first_name'] . " " . $member_row['last_name'] . "!"?></a></li>
					<li><a href="index.php">Main Site</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="container" style="background-color:rgba(255,255,255,0.6);">
		<h2 class="subheader">Event Sign-Up</h2>
		<hr>

		<!-- Validation
		0 = success
		1 = query error
		2 = already exists -->

		<?php
		if(isset($_GET['success'])){
			if($_GET['success']==0){
				print "Successfully signed up!";
			}
			else if($_GET['success']==1){
				print "Error in signing up.";
			}
			else if($_GET['success']==2){
				print "Already signed up for this event!";
			}
		}
		?>
		<div class="container">
			<h2 class="form-heading">Search for Events</h2>
			<form class="form-horizontal" action="member.php" method="POST">
				<div class="col-md-6">
					<input type="text" class="form-control input-medium search-query" placeholder="Search for Event" name="search" autofocus value="<?php if(isset($_POST['search'])) print $_POST['search']; ?>">
				</div>
				<div class="col-md-3">
					<button type="submit" class="btn btn-lg btn-primary btn-block"> Search</button>
				</div>
				<div class="col-md-3"></div>
			</form>
		</div>
		
		
		<div class="container">
			<!-- Event Listing -->
			<h2 class="form-heading">Event Listing</h2>

			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th><a href="?sorte=event_id">ID #</a></th>
							<th><a href="?sorte=ename">Event</a></th>
							<th><a href="?sorte=etype">Type</a></th>
							<th><a href="?sorte=location">Location</a></th>
							<th><a href="?sorte=start_date">Date</a></th>
							<th><a href="?sorte=start_time">Time</a></th>
						</tr>
					</thead>
					<tbody>
						<?php print $upevents?>
					</tbody>
				</table>
			</div> <!-- table -->
		</div> <!-- row with sidebar and page center -->
	</div> <!-- container --></div>
	<form id='event_more' action="dbSignUp.php" method="POST">
		<input type='hidden' id='event_id' name='event_id' value=''>
		<!-- <input type="hidden" id="member_id" name="member_id" value='5'> -->
		<input type="hidden" id="member_id" name="member_id" value='<?php print $_SESSION['member_id']?>'>
	</form>
</body>
</html>