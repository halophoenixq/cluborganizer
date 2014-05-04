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

  // members
  $query = "SELECT MEMBER_ID, FIRST_NAME, LAST_NAME, PHONE, EMAIL,CLASS_STANDING.NAME AS CSNAME, MAJOR.NAME AS MNAME, SIGNTIME ";
  $query .= "FROM CORE.PROSPECTIVE LEFT JOIN CORE.CLASS_STANDING ON PROSPECTIVE.CLASS_STAND_ID = CLASS_STANDING.CLASS_STAND_ID LEFT JOIN CORE.MAJOR ON PROSPECTIVE.MAJOR_ID = MAJOR.MAJOR_ID ";
  $query .= "WHERE PROSPECTIVE.ACTIVE = '1' ";
  if(isset($_GET['sortm'])){
    $sortm = $_GET['sortm'];
    str_replace("'", "", $sortm);
    echo $sortm;
    $query .= "ORDER BY $sortm";
  }
  else{
    $query .= "ORDER BY SIGNTIME";
  }

  $result = mysqli_query($con, $query) or die("Query failed." . mysqli_error($con));

  $allmembers = "";

  while($row = mysqli_fetch_array($result)){
    $allmembers .= "<tr data-id={$row['MEMBER_ID']} onclick='submit(this)'>";
    $allmembers .= "<td>{$row['MEMBER_ID']}</td>";
    $allmembers .= "<td>{$row['FIRST_NAME']}</td>";
    $allmembers .= "<td>{$row['LAST_NAME']}</td>";
    $allmembers .= "<td>{$row['EMAIL']}</td>";
    $allmembers .= "<td>{$row['PHONE']}</td>";
    $allmembers .= "<td>{$row['CSNAME']}</td>";
    $allmembers .= "<td>{$row['MNAME']}</td>";
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
      var form = document.getElementById('prospective_more');
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
            <li class="active"><a href="addMember.php">Add Member</a></li>
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
          <li><a href="photoManage.php">Manage Photos</a></li>
        </ul>
        <ul class="nav nav-sidebar">
          <li><label for="">MEMBER</label></li>
          <li class="active"><a href="addMember.php">Add Member</a></li>
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
        <h1 class="page-header">Member Management</h1>

        <!-- Member Listing -->
        <h2 class="form-heading">Prospective Member List</h2>
        
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
            print "<p class='error'>Member Successfully Edited!</p>";
          }
          elseif($_GET['success']==1){
            print "<p class='error'>Error in Editing Member.</p>";
          }
          ?>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th><a href="?sorte=MEMBER_ID">ID #</a></th>
                <th><a href="?sorte=FIRST_NAME">First Name</a></th>
                <th><a href="?sorte=LAST_NAME">Last Name</a></th>
                <th><a href="?sorte=EMAIL">Email</a></th>
                <th><a href="?sorte=PHONE">Phone</a></th>
                <th><a href="?sorte=CSNAME">Class Standing</a></th>
                <th><a href="?sorte=MNAME">Major</a></th>
              </tr>
            </thead>
            <tbody>
              <?php print $allmembers?>
            </tbody>
          </table>
        </div> <!-- table -->
      </div> <!-- page center -->
    </div> <!-- row with sidebar and page center -->
  </div> <!-- container -->
  
  <form id='prospective_more' action="addMember.php" method="POST">
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
