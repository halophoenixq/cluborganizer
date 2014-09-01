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

  //find member
  if(isset($_POST['member_id'])){
    $prospective_id=$_POST['member_id'];
    $query="SELECT FIRST_NAME, LAST_NAME, PHONE, EMAIL, CLASS_STAND_ID, GRAD_YEAR, MAJOR_ID ";
    $query.= "FROM CORE.PROSPECTIVE WHERE MEMBER_ID='$prospective_id'";
    $result=mysqli_query($con, $query) or die("Query failed.");
    $member_row=mysqli_fetch_array($result);
  }

  // populate class standing
  $query="SELECT * FROM CORE.CLASS_STANDING";
  $result= mysqli_query($con, $query) or die("Query failed.");
  $class_stand_opt = "";
  while($row=mysqli_fetch_array($result)) {
    $class_stand_opt .= "<option ";
    if(isset($_POST['member_id']) && $row['CLASS_STAND_ID'] == $member_row['CLASS_STAND_ID']){
      $class_stand_opt .= "selected ";
    }
    $class_stand_opt .= "value={$row['CLASS_STAND_ID']}>{$row['NAME']}</option>\n";
  }

  // populate major
  $query="SELECT * FROM CORE.MAJOR ORDER BY MAJOR.NAME";
  $result= mysqli_query($con, $query) or die("Query failed.");
  $major_opt = "";
  while($row=mysqli_fetch_array($result)) {
    $major_opt .= "<option value={$row['MAJOR_ID']}";
    if(isset($_POST['member_id'])){
      if($row['MAJOR_ID'] == $member_row['MAJOR_ID']){
        $major_opt .= " selected";
      }
    }
    $major_opt .= ">{$row['NAME']}</option>\n";
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
        <h1 class="page-header" id="test">Member Management</h1>

        <div class="container">
          <form action="interestList.php">
            <button class="btn btn-lg btn-primary btn-block" type="submit">Prospective Members</button>
          </form>
        </div>

        <div class="container">
          <h2 class="form-heading">Add New Member</h2>

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
            print "<p class='error'>Member Successfully Added!</p>";
          }
          elseif($_GET['success']==1){
            print "<p class='error'>Error in Adding Member.</p>";
          }
          ?>
          <form class="form-horizontal" role="form" action="dbAddMember.php" method="POST">

            <!-- Member First Name -->
            <div class="form-group">
              <label for="fname" class="col-sm-2 control-label">First Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="First Name" id="fname" name="fname" required autofocus value="<?php if(isset($_POST['member_id'])) print $member_row['FIRST_NAME']?>">
              </div>
            </div>

            <!-- Member Last Name -->
            <div class="form-group">
              <label for="lname" class="col-sm-2 control-label">Last Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Last Name" id="lname" name="lname" required value="<?php if(isset($_POST['member_id'])) print $member_row['LAST_NAME']?>">
              </div>
            </div>

            <!-- Username -->
            <div class="form-group">
              <label for="username" class="col-sm-2 control-label">Username</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Username" id="username" name="username" maxlength="20" required>
              </div>
            </div>

            <!-- Password -->
            <div class="form-group">
              <label for="password" class="col-sm-2 control-label">Password</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Password" id="password" name="password" maxlength="20" required>
              </div>
            </div>

            <!-- Class Standing -->
            <div class="form-group">
              <label for="class_stand" class="col-sm-2 control-label">Class Standing</label>
              <div class="col-sm-10">
                <select class="form-control" name="class_stand" id="class_stand" required>
                  <?php print $class_stand_opt?>
                </select>
              </div>
            </div>

            <!-- Email -->
            <div class="form-group">
              <label for="email" class="col-sm-2 control-label">Email</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" placeholder="Email" id="email" name="email" required value="<?php if(isset($_POST['member_id'])) print $member_row['EMAIL']?>">
              </div>
            </div>

            <!-- Phone -->
            <div class="form-group">
              <label for="phone" class="col-sm-2 control-label">Phone</label>
              <div class="col-sm-10">
                <input type="tel" class="form-control" placeholder="Phone" id="phone" name="phone" required value="<?php if(isset($_POST['member_id'])) print $member_row['PHONE']?>">
              </div>
            </div>

            <!-- Major -->
            <div class="form-group">
              <label for="major" class="col-sm-2 control-label">Major</label>
              <div class="col-sm-10">
                <select class="form-control" name="major" id="major" required>
                  <?php print $major_opt?>
                </select>
              </div>
            </div>

            <!-- Grad Year -->
            <div class="form-group">
              <label for="grad" class="col-sm-2 control-label">Graduation Year</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Graduation Year" id="grad" name="grad" required value="<?php if(isset($_POST['member_id'])) print $member_row['GRAD_YEAR']?>">
              </div>
            </div>

            <div class="form-group">
              <label for="join_date" class="col-sm-2 control-label">Join Date</label>
              <div class="col-sm-10 input-group date" id="join_date" data-date-format="MM/DD/YYYY">
                <input class="span2 form-control" type="text" name="join_date" required>
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
              </div>
            </div>

            <!-- Comments -->
            <div class="form-group">
              <label for="comment" class="col-sm-2 control-label">Comments</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="comment" name="comment" rows="4"></textarea>
              </div>
            </div>

            <!-- Button -->
            <div class="col-md-4"></div>
            <div class="col-md-4">
              <button class="btn btn-lg btn-primary btn-block" type="submit">Add Member</button>
            </div>

            <input type="hidden" name="prospective" value="<?php if(isset($_POST['member_id'])) print $prospective_id ?>">
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
      $("#join_date").datetimepicker({
        defaultDate: moment(),
        pickTime: false
      });
    });
  </script>
</body>
</html>
