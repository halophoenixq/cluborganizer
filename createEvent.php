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

  <title>Admin Portal</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.css" rel="stylesheet">
  
  <!-- Custom styles for this template -->
  <link href="css/dashboard.css" rel="stylesheet">

  <!-- Bootstrap datetimepicker -->
  <link href="css/bootstrap-datetimepicker.css" rel="stylesheet">

  <!-- Jquery -->
  <script src="js/jquery.min.js"></script>
  <script src="js/moment.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap-datetimepicker.js"></script>

  <!-- Queries -->
  <?php
  include('connect.php');

  // populate event type
  $query="SELECT * FROM CORE.EVENT_TYPE";
  $result= mysqli_query($con, $query) or die("Query failed.");
  $event_type_opt = "";
  while($row=mysqli_fetch_array($result)) {
    $event_type_opt .= "<option value={$row['EVENT_TYPE_ID']}>{$row['NAME']}</option>\n";
  }
  ?>
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
            <li class="active"><a href="createEvent.php">Create Event</a></li>
            <li><a href="editEvent.php">Edit Event</a></li>
            <li><a href="searchEvent.php">Search Event</a></li>
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
          <li class="active"><a href="createEvent.php">Create Event</a></li>
          <li><a href="editEvent.php">Edit Event</a></li>
          <li><a href="searchEvent.php">Search Event</a></li>
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
        <h1 class="page-header" id="test">Event Management</h1>

        <div class="container">
          <h2 class="form-heading">Create New Event</h2>

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
            print "<p class='error'>Event Successfully Added!</p>";
          }
          elseif($_GET['success']==1){
            print "<p class='error'>Error in adding dvd.</p>";
          }
          elseif($_GET['success']==2){
            print "<p class='error'>Error in adding dvd. Invalid ID</p>";
          }
          elseif($_GET['success']==3){
            print "<p class='error'>Error in adding dvd. Invalid Title.</p>";
          }
          elseif($_GET['success']==4){
            print "<p class='error'>Error in adding dvd. Invalid Price.</p>";
          }
          elseif($_GET['success']==5){
            print "<p class='error'>Error in adding dvd. ID Exists.</p>";
          }
          ?>
          <form class="form-horizontal" role="form" action="dbCreateEvent.php" method="POST">
            
            <!-- Event Name -->
            <div class="form-group">
              <label for="event_name" class="col-sm-2 control-label">Event Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Event Name" id="event_name" name="event_name" required autofocus>
              </div>
            </div>

            <!-- Event Type -->
            <div class="form-group">
              <label for="event_type" class="col-sm-2 control-label">Event Type</label>
              <div class="col-sm-10">
                <select class="form-control" name="event_type" id="event_type" required>
                  <?php print $event_type_opt?>
                </select>
              </div>
            </div>

            <!-- Date -->
            <div class="form-group">
              <label for="start_date" class="col-sm-2 control-label">Date</label>
              <div class="col-sm-10 input-group date" id="start_date" data-date-format="MM/DD/YYYY">
                <input class="span2 form-control" type="text" name="start_date" required>
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
              </div>
            </div>
            
            <!-- Start Time -->
            <div class="form-group">
              <label for="start_time" class="col-sm-2 control-label">Start Time</label>
              
              <div class="col-sm-10 input-group date" id="start_time">
                <input class="form-control" type="text" name="start_time" required>
                <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
              </div>
            </div>

            <!-- End Time -->
            <div class="form-group">
              <label for="end_time" class="col-sm-2 control-label">End Time</label>
              
              <div class="col-sm-10 input-group date" id="end_time">
                <input class="form-control" type="text" name="end_time" required>
                <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
              </div>
            </div>

            <!-- Location -->
            <div class="form-group">
              <label for="location" class="col-sm-2 control-label">Location</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Location" id="location" name="location" required>
              </div>
            </div>

            <!-- Description -->
            <div class="form-group">
              <label for="description" class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" placeholder="Description" id="description" name="description" rows="4"></textarea>
              </div>
            </div>

            <!-- Button -->
            <div class="col-md-4"></div>
            <div class="col-md-4">
              <button class="btn btn-lg btn-primary btn-block" type="submit">Create Event</button>
            </div>
          </form>
        </div><!-- /.container -->

      </div> <!-- page center -->
    </div> <!-- row with sidebar and page center -->
  </div> <!-- container -->

  <!-- JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <!-- // <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
  <!-- // <script src="js/docs.min.js"></script> -->
  <!-- <script src="js/bootstrap-datepicker.js"></script> -->
  

  <!-- datepicker -->
  <script type="text/javascript">
    $(document).ready(function(){
      $("#start_date").datetimepicker({
        pickTime: false
      });
    });
  </script>

  <!-- timepicker -->
  <script type="text/javascript">
    $(document).ready(function(){
      $("#start_time").datetimepicker({
        pickDate: false
      });
      $("#end_time").datetimepicker({
        pickDate: false
      });
    });
  </script>
</body>
</html>
