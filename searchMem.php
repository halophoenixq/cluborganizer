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

  // members
  $query = "SELECT MEMBER_ID, FIRST_NAME, LAST_NAME, USERNAME, PHONE, EMAIL, CLASS.NAME AS CNAME, RANK.NAME AS RNAME, CLASS_STANDING.NAME AS CSNAME, ACTIVE ";
  $query .= "FROM CORE.MEMBER LEFT JOIN CORE.CLASS ON MEMBER.CLASS_ID = CLASS.CLASS_ID LEFT JOIN CORE.RANK ON MEMBER.RANK_ID = RANK.RANK_ID LEFT JOIN CORE.CLASS_STANDING ON MEMBER.CLASS_STAND_ID = CLASS_STANDING.CLASS_STAND_ID ";
  //search part
  if(isset($_POST['search'])){
    $term = mysqli_escape_string($con, $_POST['search']);
    $query .= "WHERE member.first_name LIKE '%$term%' OR member.LAST_NAME LIKE '%$term%' ";
  }
  if(isset($_GET['sort'])){
    $sort = $_GET['sort'];
    str_replace("'", "", $sort);
    echo $sort;
    $query .= "ORDER BY $sort";
  }
  else{
    $query .= "ORDER BY FIRST_NAME";
  }

  $result = mysqli_query($con, $query) or die("Query failed." . mysqli_error($con));

  $allmembers = "";

  while($row = mysqli_fetch_array($result)){
    $allmembers .= "<tr data-id={$row['MEMBER_ID']} onclick='submit(this)'>";
    $allmembers .= "<td>{$row['MEMBER_ID']}</td>";
    $allmembers .= "<td>{$row['USERNAME']}</td>";
    $allmembers .= "<td>{$row['FIRST_NAME']}</td>";
    $allmembers .= "<td>{$row['LAST_NAME']}</td>";
    $allmembers .= "<td>{$row['EMAIL']}</td>";
    $allmembers .= "<td>{$row['PHONE']}</td>";
    $allmembers .= "<td>{$row['CSNAME']}</td>";
    $allmembers .= "<td>{$row['CNAME']}</td>";
    $allmembers .= "<td>{$row['RNAME']}</td>";
    $allmembers .= "</tr>\n";
  }
  ?>

  <!-- Click Script -->
  <script type="text/javascript">
    function submit(tableRow) {
      //get ID
      var myID = tableRow.dataset.id;

      document.getElementById('member_id').value = myID;
      
      //submit
      var form = document.getElementById('member_more');
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

        <div class="container">
          <h2 class="form-heading">Search for Members</h2>
          <form class="form-horizontal" action="searchMem.php" method="POST">
            <div class="col-md-6">
              <input type="text" class="form-control input-medium search-query" name="search" placeholder="Search by Name" value="<?php if(isset($_POST['search'])) print $_POST['search']?>" autofocus>
            </div>
            <div class="col-md-3">
              <button type="submit" class="btn btn-lg btn-primary btn-block"> Search</button>
            </div>
            <div class="col-md-3"></div>
          </form>
        </div>

        
        <div class="container">
          <!-- Member Listing -->
          <h2 class="form-heading">Member Listing</h2>

          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th><a href="?sort=member_id">ID #</a></th>
                  <th><a href="?sort=username">Username</a></th>
                  <th><a href="?sort=first_name">First Name</a></th>
                  <th><a href="?sort=last_name">Last Name</a></th>
                  <th><a href="?sort=email">Email</a></th>
                  <th><a href="?sort=phone">Phone</a></th>
                  <th><a href="?sort=csname">Class Standing</a></th>
                  <th><a href="?sort=cname">Class</a></th>
                  <th><a href="?sort=rname">Rank</a></th>
                </tr>
              </thead>
              <tbody>
                <?php print $allmembers?>
              </tbody>
            </table>
          </div> <!-- table -->
        </div> <!-- container -->
      </div> <!-- page center -->
    </div> <!-- row with sidebar and page center -->
  </div> <!-- container -->

  <form id='member_more' action="memberDetails.php" method="POST">
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
