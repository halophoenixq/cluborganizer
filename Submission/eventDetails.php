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
  $event_id=$_POST['event_id'];

  $query="SELECT event.NAME AS ename, EVENT_TYPE.name AS etype, location, event.DESCRIPTION AS edesc, DATE_FORMAT(start_date,'%c/%e/%Y') AS sdate, DATE_FORMAT(start_time,'%l:%i %p') AS stime, DATE_FORMAT(end_time,'%l:%i %p') AS etime ";
  $query.= "FROM core.event LEFT JOIN core.event_type ON event.event_type_id = event_type.event_type_id WHERE event_id='$event_id'";
  $result=mysqli_query($con,$query) or die("Query failed." . mysqli_error($con));
  $event_row=mysqli_fetch_array($result);

  //Sign Up Query
  $query="SELECT * FROM core.signup LEFT JOIN core.member ON signup.member_id = member.member_id WHERE event_id='$event_id'";
  $result=mysqli_query($con,$query) or die("Query failed." . mysqli_error($con));

  $suevents = "";
  $count=1;
  while($row = mysqli_fetch_array($result)){
    $suevents .= "<tr data-id={$row['MEMBER_ID']} onclick='submit(this)'>";
    $suevents .= "<td>$count</td>";
    $count+= 1;
    $suevents .= "<td>{$row['FIRST_NAME']}</td>";
    $suevents .= "<td>{$row['LAST_NAME']}</td>";
    $suevents .= "<td>{$row['EMAIL']}</td>";
    $suevents .= "<td>{$row['PHONE']}</td>";
    $suevents .= "<td>{$row['SIGNUP_TIME']}</td>";
    $suevents .= "</tr>\n";
  }

  //Sign In Query
  $query="SELECT * FROM core.signin LEFT JOIN core.member ON signin.member_id = member.member_id WHERE event_id='$event_id'";
  $result=mysqli_query($con,$query) or die("Query failed." . mysqli_error($con));

  $sievents = "";
  $count=1;
  while($row = mysqli_fetch_array($result)){
    $sievents .= "<tr data-id={$row['MEMBER_ID']} onclick='submit(this)'>";
    $sievents .= "<td>$count</td>";
    $count+= 1;
    $sievents .= "<td>{$row['FIRST_NAME']}</td>";
    $sievents .= "<td>{$row['LAST_NAME']}</td>";
    $sievents .= "<td>{$row['EMAIL']}</td>";
    $sievents .= "<td>{$row['PHONE']}</td>";
    $sievents .= "<td>{$row['SIGNIN_TIME']}</td>";
    $sievents .= "</tr>\n";
  }
  ?>

  <!-- Click Script -->
  <script type="text/javascript">
    function submit(tableRow) {
      //get ID
      var myID = tableRow.dataset.id;

      document.getElementById('member_id').value = myID;
      
      //submit
      var form = document.getElementById('mForm');
      form.submit();
    };
    function edit() {
      //submit
      var form = document.getElementById('eForm');
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
          <li ><a href="portal.php">Dashboard</a></li>
          <li><a href="index.php">Main Site</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
        <ul id="extraNav" class="nav navbar-nav navbar-right">
          <li><label for="" style="color:white;">EVENT</label></li>
          <li><a href="createEvent.php">Create Event</a></li>
          <li><a href="editEvent.php">Edit Event</a></li>
          <li class="active"><a href="searchEvent.php">Search Event</a></li>
          <li><a href="photoManage.php">Manage Photos</a></li>
          <li><label for="" style="color:white;">MEMBER</label></li>
          <li><a href="addMember.php">Add Member</a></li>
          <li><a href="editMember.php">Edit Member</a></li>
          <li><a href="searchMem.php">Search Member</a></li>
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
          <li class="active"><a href="searchEvent.php">Search Event</a></li>
          <li><a href="photoManage.php">Manage Photos</a></li>
        </ul>
        <ul class="nav nav-sidebar">
          <li><label for="">MEMBER</label></li>
          <li><a href="addMember.php">Add Member</a></li>
          <li><a href="editMember.php">Edit Member</a></li>
          <li><a href="searchMem.php">Search Member</a></li>
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
        <h1 class="page-header">Event Management</h1>

        <!-- Event Listing -->
        <h2 class="sub-header">Event Details <button type="button" class="btn btn-default" onclick="edit();">Edit</button></h2> 
        
        <!-- Event Details -->
        <!-- Event ID -->
        <div class="container">
          <input type="hidden" name="event_id" value="<?php print $event_id?>">
          <div class="col-sm-6 table-responsive table-bordered">
            <table class="table">
              <tr>
                <td><strong>Event Name</strong></td>
                <td><?php print $event_row['ename']?></td>
              </tr>
              <tr>
                <td><strong>Event Type</strong></td>
                <td><?php print $event_row['etype']?></td>
              </tr>
              <tr>
                <td><strong>Description</strong></td>
                <td><?php print $event_row['edesc']?></td>
              </tr>
            </table>
          </div>
          
          <div class="col-sm-6 table-responsive table-bordered">
            <table class="table">
              <tr>
                <td><strong>Date</strong></td>
                <td><?php print $event_row['sdate']?></td>
              </tr>
              <tr>
                <td><strong>Time</strong></td>
                <td><?php print $event_row['stime'] . " - " . $event_row['etime']?></td>
              </tr>
              <tr>
                <td><strong>Location</strong></td>
                <td><?php print $event_row['location']?></td>
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
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Timestamp</th>
              </tr>
            </thead>
            <tbody>
              <?php print $suevents?>
            </tbody>
          </table>
        </div> <!-- table -->

        <h3 class="col-sm-6 form-heading">Sign-ins</h3>
        <div class="col-sm-10 table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Timestamp</th>
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

  <form id='eForm' action="editEventEntry.php" method="POST">
    <input type='hidden' id='event_id' name='event_id' value='<?php print $event_id?>'>
  </form>
  <form id='mForm' action="memberDetails.php" method="POST">
    <input type='hidden' id='member_id' name='member_id' value=''>
  </form>

  <!-- JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/docs.min.js"></script>
</body>
</html>
