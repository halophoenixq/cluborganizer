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

  <!-- Jasny Bootstrap for file upload -->
  <link href="css/jasny-bootstrap.min.css" rel="stylesheet">  

  <!-- Custom styles for this template -->
  <link href="css/dashboard.css" rel="stylesheet">

  <!-- Queries -->
  <?php
  include('connect.php');
  $event_id=$_POST['event_id'];

  // populate event type
  $query="SELECT * FROM CORE.PHOTO_TYPE";
  $result= mysqli_query($con, $query) or die("Query failed.");
  $photo_type_opt = "";
  while($row=mysqli_fetch_array($result)) {
    $photo_type_opt .= "<option value={$row['PHOTO_TYPE_ID']}>{$row['NAME']}</option>\n";
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
          <li ><a href="portal.php">Dashboard</a></li>
          <li><a href="index.php">Main Site</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
        <ul id="extraNav" class="nav navbar-nav navbar-right">
          <li><label for="" style="color:white;">EVENT</label></li>
          <li><a href="createEvent.php">Create Event</a></li>
          <li><a href="editEvent.php">Edit Event</a></li>
          <li><a href="searchEvent.php">Search Event</a></li>
          <li class="active"><a href="photoManage.php">Manage Photos</a></li>
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
          <li><a href="searchEvent.php">Search Event</a></li>
          <li class="active"><a href="photoManage.php">Manage Photos</a></li>
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
        <h1 class="page-header">Photo Management</h1>

        <!-- Event Listing -->
        <h2 class="sub-header">Event Details</h2>

        <!-- The data encoding type, enctype, MUST be specified as below -->
        <form class="form-horizontal" enctype="multipart/form-data" action="dbUploadPhoto.php" method="POST">
          <!-- MAX_FILE_SIZE must precede the file input field -->
          <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />

          <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
              <img data-src="holder.js/100%x100%" alt="...">
            </div>
            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
            <div>
              <span class="btn btn-default btn-file">
                <span class="fileinput-new">Select image</span>
                <span class="fileinput-exists">Change</span>
                <input type="file" name="uPhoto"></span>
                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
              </div>
            </div>

            <!-- Event ID -->
            <div class="form-group">
              <label for="event_id" class="col-sm-2 control-label">Event ID</label>
              <div class="col-sm-10">
                <input class="form-control" type="text" disabled="true" value="<?php print $event_id?>">
                <input type="hidden" name="event_id" value="<?php print $event_id?>">
              </div>
            </div>
            
            <!-- Photo Type -->
            <div class="form-group">
              <label for="type_id" class="col-sm-2 control-label">Photo Type</label>
              <div class="col-sm-10">
                <select class="form-control" name="type_id" id="type_id" required>
                  <?php print $photo_type_opt?>
                </select>
              </div>
            </div>

            <!-- Name -->
            <div class="form-group">
              <label for="photo_name" class="col-sm-2 control-label">Photo Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Photo Name" id="photo_name" name="photo_name" required>
              </div>
            </div>

            <!-- Description -->
            <div class="form-group">
              <label for="description" class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
              </div>
            </div>

            <div class="col-md-4"></div>
            <div class="col-md-4">
            <input class="btn btn-lg btn-primary btn-block" type="submit" value="Upload Photo" class="form-control"/>
            </div>
          </form>

        </div> <!-- page center -->
      </div> <!-- row with sidebar and page center -->
    </div> <!-- container -->

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jasny-bootstrap.min.js"></script>
    <script src="js/holder.js"></script>

  </body>
  </html>
