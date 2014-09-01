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

  // all events
  $query = "SELECT event_id, event.name AS ename, event_type.name AS etype, location, DATE_FORMAT(start_date,'%c/%d/%Y') AS sdate, DATE_FORMAT(start_time,'%h:%i %p') AS stime, DATE_FORMAT(end_time,'%l:%i %p') AS etime ";
  $query .= "FROM core.event LEFT JOIN core.event_type ON event.event_type_id = event_type.event_type_id ";
  //search part
  if(isset($_POST['search'])){
    $term = mysqli_escape_string($con, $_POST['search']);
    $query .= "WHERE event.name LIKE '%$term%' ";
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

  $allevents = "";

  while($row = mysqli_fetch_array($result)){
    $allevents .= "<tr data-id={$row['event_id']} onclick='submit(this)'>";
    $allevents .= "<td>{$row['event_id']}</td>";
    $allevents .= "<td>{$row['ename']}</td>";
    $allevents .= "<td>{$row['etype']}</td>";
    $allevents .= "<td>{$row['location']}</td>";
    $allevents .= "<td>{$row['sdate']}</td>";
    $allevents .= "<td>{$row['stime']} - {$row['etime']}</td>";
    $allevents .= "</tr>\n";
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

        <div class="container">
          <h2 class="form-heading">Search for Events</h2>
          <form class="form-horizontal" action="searchEvent.php" method="POST">
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
          
          <!-- validation
            0 = success
            1 = query failure
            2 = id error
            3 = title not valid
            4 = price not valid-->
            <?php
            if(!isset($_GET['success'])){

            }
            elseif($_GET['success']==0){
              print "<p class='error'>Event Successfully Edited!</p>";
            }
            elseif($_GET['success']==1){
              print "<p class='error'>Error in Editing Event.</p>";
            }
            ?>
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
                  <?php print $allevents?>
                </tbody>
              </table>
            </div> <!-- table -->
          </div></div> <!-- page center -->
        </div> <!-- row with sidebar and page center -->
      </div> <!-- container -->

      <form id='event_more' action="eventDetails.php" method="POST">
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
