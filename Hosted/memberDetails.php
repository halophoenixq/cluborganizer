<?php
session_start();
if(!isset($_SESSION['admin'])){
  header("Location:admin_login.php?loginFailed=true&reason=login");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

  <title>Admin Portal</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/dashboard.css" rel="stylesheet">

  <!-- Queries -->
  <?php
  include('connect.php');
  $member_id=$_POST['member_id'];

  // Member info
  $query="SELECT first_name, last_name, phone, email, grad_year, DATE_FORMAT(join_date,'%c/%e/%Y'), active, comments, username, MAJOR.name AS majorname, CLASS.name AS classname,  CLASS_STANDING.name AS classstandname, RANK.name AS rankname ";
  $query.= "FROM MEMBER LEFT JOIN CLASS ON MEMBER.class_id = CLASS.class_id LEFT JOIN RANK ON MEMBER.rank_id = RANK.rank_id LEFT JOIN CLASS_STANDING ON MEMBER.class_stand_id = CLASS_STANDING.class_stand_id LEFT JOIN MAJOR ON MEMBER.major_id = MAJOR.major_id ";
  $query .= "WHERE member_id='$member_id'";
  $result=mysqli_query($con,$query) or die("Query failed." . mysqli_error($con));
  $member_row=mysqli_fetch_array($result);

  //Sign Up Query
  $query="SELECT EVENT.EVENT_ID AS eid, EVENT.NAME AS ename, EVENT_TYPE.name AS etype, LOCATION, DATE_FORMAT(start_date,'%c/%e/%Y') AS sdate, DATE_FORMAT(start_time,'%l:%i %p') AS stime, DATE_FORMAT(end_time,'%l:%i %p') AS etime ";
  $query .= "FROM EVENT LEFT JOIN SIGNUP ON SIGNUP.EVENT_ID = EVENT.EVENT_ID LEFT JOIN EVENT_TYPE ON EVENT.EVENT_TYPE_ID = EVENT_TYPE.EVENT_TYPE_ID WHERE SIGNUP.MEMBER_ID='$member_id'";
  $result=mysqli_query($con,$query) or die("Query failed." . mysqli_error($con));

  $suevents = "";
  $count=1;
  while($row = mysqli_fetch_array($result)){
    $suevents .= "<tr data-id={$row['eid']} onclick='submit(this)'>";
    $suevents .= "<td>$count</td>";
    $count+= 1;
    $suevents .= "<td>{$row['ename']}</td>";
    $suevents .= "<td>{$row['etype']}</td>";
    $suevents .= "<td>{$row['LOCATION']}</td>";
    $suevents .= "<td>{$row['sdate']}</td>";
    $suevents .= "<td>{$row['stime']} - {$row['etime']}</td>";
  }

  // Sign in Query
  //Sign Up Query
  $query="SELECT EVENT.EVENT_ID AS eid, EVENT.NAME AS ename, EVENT_TYPE.name AS etype, LOCATION, DATE_FORMAT(start_date,'%c/%e/%Y') AS sdate, DATE_FORMAT(start_time,'%l:%i %p') AS stime, DATE_FORMAT(end_time,'%l:%i %p') AS etime  FROM SIGNIN LEFT JOIN EVENT ON SIGNIN.event_id = EVENT.event_id LEFT JOIN EVENT_TYPE ON EVENT.event_type_id = EVENT_TYPE.event_type_id WHERE SIGNIN.member_id='$member_id'";
  $result=mysqli_query($con,$query) or die("Query failed." . mysqli_error($con));

  $sievents = "";
  $count=1;
  while($row = mysqli_fetch_array($result)){
    $sievents .= "<tr data-id={$row['eid']} onclick='submit(this)'>";
    $sievents .= "<td>$count</td>";
    $count+= 1;
    $sievents .= "<td>{$row['ename']}</td>";
    $sievents .= "<td>{$row['etype']}</td>";
    $sievents .= "<td>{$row['LOCATION']}</td>";
    $sievents .= "<td>{$row['sdate']}</td>";
    $sievents .= "<td>{$row['stime']} - {$row['etime']}</td>";
  }
  ?>

  <!-- Click Script -->
  <script type="text/javascript">
    function submit(tableRow) {
      //get ID
      var myID = tableRow.dataset.id;

      document.getElementById('event_id').value = myID;
      
      //submit
      var form = document.getElementById('eForm');
      form.submit();
    };
    function edit() {
      //submit
      var form = document.getElementById('mForm');
      form.submit();
    };    
  </script>
</head>

<body>

  <!-- Top Navbar -->
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <!-- Responsive Navbar -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="portal.php">Admin Home</a>
      </div>
      <!-- Navbar Items -->
      <div class="navbar-collapse collapse">
        <!-- Searchbar -->
        <form class="navbar-form navbar-right" action="searchEvent.php" method="POST">
          <input type="text" class="form-control" placeholder="Search Event" name="search">
        </form>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="portal.php">Dashboard</a></li>
          <li><a href="index.php">Main Site</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
        <ul id="extraNav" class="nav navbar-nav navbar-right">
          <li><label for="" style="color:white;">EVENT</label></li>
          <li><a href="createEvent.php">Create Event</a></li>
          <li><a href="editEvent.php">Edit Event</a></li>
          <li><a href="searchEvent.php">Search Event</a></li>
          <li><a href="photoManage.php">Manage Photos</a></li>
          <li><label for="" style="color:white;">MEMBER</label></li>
          <li><a href="addMember.php">Add Member</a></li>
          <li><a href="editMember.php">Edit Member</a></li>
          <li class="active"><a href="searchMem.php">Search Member</a></li>
          <li><a href="sendEmail.php">Send Email</a></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Sidebar -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
          <li><a href="portal.php">Overview</a></li>
        </ul>
        <ul class="nav nav-sidebar">
          <li><label for="">EVENT</label></li>
          <li><a href="createEvent.php">Create Event</a></li>
          <li><a href="editEvent.php">Edit Event</a></li>
          <li><a href="searchEvent.php">Search Event</a></li>
          <li><a href="photoManage.php">Manage Photos</a></li>
        </ul>
        <ul class="nav nav-sidebar">
          <li><label for="">MEMBER</label></li>
          <li><a href="addMember.php">Add Member</a></li>
          <li><a href="editMember.php">Edit Member</a></li>
          <li class="active"><a href="searchMem.php">Search Member</a></li>
          <li><a href="sendEmail.php">Send Email</a></li>
        </ul>
        <!-- <ul class="nav nav-sidebar">
          <li><label for="">FINANCE</label></li>
          <li><a href="">One more nav</a></li>
          <li><a href="">Another nav item</a></li>
        </ul> -->
      </div>

      <!-- Page Center -->
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1 class="page-header">Member Management</h1>

        <!-- Member Listing -->
        <h2 class="sub-header">Member Details <button type="button" class="btn btn-default" onclick="edit();">Edit</button></h2> 
        
        <!-- Member Details -->
        <!-- Member ID -->
        <div class="container">
          <input type="hidden" name="member_id" value="<?php print $member_id?>">
          <div class="col-sm-6 table-responsive table-bordered">
            <table class="table">
              <tr>
                <td><strong>First Name</strong></td>
                <td><?php print $member_row['first_name']?></td>
              </tr>
              <tr>
                <td><strong>Last Name</strong></td>
                <td><?php print $member_row['last_name']?></td>
              </tr>
              <tr>
                <td><strong>Email</strong></td>
                <td><?php print $member_row['email']?></td>
              </tr>
              <tr>
                <td><strong>Phone</strong></td>
                <td><?php print $member_row['phone']?></td>
              </tr>
              <tr>
                <td><strong>Username</strong></td>
                <td><?php print $member_row['username']?></td>
              </tr>
              
            </table>
          </div>
          
          <div class="col-sm-6 table-responsive table-bordered">
            <table class="table">
              <tr>
                <td><strong>Class</strong></td>
                <td><?php print $member_row['classname']?></td>
              </tr>
              <tr>
                <td><strong>Rank</strong></td>
                <td><?php print $member_row['rankname']?></td>
              </tr>
              <tr>
                <td><strong>Major</strong></td>
                <td><?php print $member_row['majorname']?></td>
              </tr>
              <tr>
                <td><strong>Active</strong></td>
                <td><?php if($member_row['active']==1) print "Yes"?><?php if($member_row['active']==0) print "No"?></td>
              </tr>
              <tr>
                <td><strong>Class Standing</strong></td>
                <td><?php print $member_row['classstandname']?></td>
              </tr>
              <tr>
                <td><strong>Comments</strong></td>
                <td><?php print $member_row['comments']?></td>
              </tr>
            </table>
          </div>
        </div>

        <h3 class="col-sm-6 form-heading">Sign-ups</h3>

        <div class="col-sm-10 table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Event Name</th>
                <th>Event Type</th>
                <th>Location</th>
                <th>Date</th>
                <th>Time</th>
              </tr>
            </thead>
            <tbody>
              <?php print $suevents?>
            </tbody>
          </table>
        </div> <!-- table -->

        <h3 class="col-sm-6 form-heading">Events Attended</h3>

        <div class="col-sm-10 table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Event Name</th>
                <th>Event Type</th>
                <th>Location</th>
                <th>Date</th>
                <th>Time</th>
              </tr>
            </thead>
            <tbody>
              <?php print $sievents?>
            </tbody>
          </table>
        </div> <!-- table -->
      </div> <!-- page center -->
    </div> <!-- row with sidebar and page center -->
  </div> <!-- container -->

  <form id='mForm' action="editMemberEntry.php" method="POST">
    <input type='hidden' id='member_id' name='member_id' value='<?php print $member_id?>'>
  </form>
  <form id='eForm' action="eventDetails.php" method="POST">
    <input type='hidden' id='event_id' name='event_id' value=''>
  </form>

  <!-- JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/docs.min.js"></script>
</body>
</html>
