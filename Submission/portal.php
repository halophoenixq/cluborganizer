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

  <!-- Javascript -->
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/highcharts.js"></script>
  <script src="js/modules/data.js"></script>
  <script src="js/modules/drilldown.js"></script>
  

  <!-- Queries -->
  <?php
  include('connect.php');

  // upcoming events
  $query = "SELECT event_id, event.name AS ename, event_type.name AS etype, location, DATE_FORMAT(start_date,'%c/%d/%Y') AS sdate, DATE_FORMAT(start_time,'%h:%i %p') AS stime, DATE_FORMAT(end_time,'%l:%i %p') AS etime ";
  $query .= "FROM core.event LEFT JOIN core.event_type ON event.event_type_id = event_type.event_type_id ";
  $query .= "WHERE ADDTIME( start_date, start_time ) > NOW( ) ";
  if(isset($_GET['sorte'])){
    $sorte = $_GET['sorte'];
    str_replace("'", "", $sorte);
    echo $sorte;
    $query .= "ORDER BY $sorte";
  }
  else{
    $query .= "ORDER BY start_date, start_time";
  }  

  $result = mysqli_query($con, $query) or die("Query failed." . mysqli_error($con));

  $upevents = "";

  while($row = mysqli_fetch_array($result)){
    $upevents .= "<tr data-id={$row['event_id']} onclick='submitevent(this)'>";
    $upevents .= "<td>{$row['event_id']}</td>";
    $upevents .= "<td>{$row['ename']}</td>";
    $upevents .= "<td>{$row['etype']}</td>";
    $upevents .= "<td>{$row['location']}</td>";
    $upevents .= "<td>{$row['sdate']}</td>";
    $upevents .= "<td>{$row['stime']} - {$row['etime']}</td>";
    $upevents .= "</tr>\n";
  }


  // members
  $query = "SELECT MEMBER_ID, FIRST_NAME, LAST_NAME, USERNAME, PHONE, EMAIL, CLASS.NAME AS CNAME, RANK.NAME AS RNAME, CLASS_STANDING.NAME AS CSNAME, ACTIVE ";
  $query .= "FROM CORE.MEMBER LEFT JOIN CORE.CLASS ON MEMBER.CLASS_ID = CLASS.CLASS_ID LEFT JOIN CORE.RANK ON MEMBER.RANK_ID = RANK.RANK_ID LEFT JOIN CORE.CLASS_STANDING ON MEMBER.CLASS_STAND_ID = CLASS_STANDING.CLASS_STAND_ID ";
  $query .= "WHERE MEMBER.ACTIVE = '1'";
  
  //search part
  if(isset($_POST['search'])){
    $term = mysqli_escape_string($con, $_POST['search']);
    $query .= "WHERE member.first_name LIKE '%$term%' OR member.LAST_NAME LIKE '%$term%' ";
  }
  if(isset($_GET['sortm'])){
    $sortm = $_GET['sortm'];
    str_replace("'", "", $sortm);
    echo $sortm;
    $query .= "ORDER BY $sortm";
  }
  else{
    $query .= "ORDER BY FIRST_NAME";
  }

  $result = mysqli_query($con, $query) or die("Query failed." . mysqli_error($con));

  $allmembers = "";

  while($row = mysqli_fetch_array($result)){
    $allmembers .= "<tr data-id={$row['MEMBER_ID']} onclick='submitmember(this)'>";
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

  // Analysis for graph
  // calculate totals per class
  $query="SELECT COUNT( * ) AS TCOUNT ";
  $query .= "FROM CORE.MEMBER LEFT JOIN CORE.CLASS ON MEMBER.CLASS_ID = CLASS.CLASS_ID LEFT JOIN CORE.RANK ON MEMBER.RANK_ID = RANK.RANK_ID LEFT JOIN CORE.CLASS_STANDING ON MEMBER.CLASS_STAND_ID = CLASS_STANDING.CLASS_STAND_ID ";
  $result = mysqli_query($con, $query) or die("Query failed." . mysqli_error($con));
  $row=mysqli_fetch_array($result);
  $total=$row['TCOUNT'];

  $query="SELECT MAJOR.NAME AS MNAME, CLASS_STANDING.NAME AS CSNAME, COUNT( * ) AS TCOUNT ";
  $query.="FROM CORE.MEMBER LEFT JOIN CORE.CLASS ON MEMBER.CLASS_ID = CLASS.CLASS_ID LEFT JOIN CORE.RANK ON MEMBER.RANK_ID = RANK.RANK_ID LEFT JOIN CORE.CLASS_STANDING ON MEMBER.CLASS_STAND_ID = CLASS_STANDING.CLASS_STAND_ID LEFT JOIN CORE.MAJOR ON MEMBER.MAJOR_ID = MAJOR.MAJOR_ID ";
  $query.="GROUP BY MAJOR.NAME, MEMBER.CLASS_STAND_ID";

  $result = mysqli_query($con, $query) or die("Query failed." . mysqli_error($con));

  $graphdata = "";
  while($row = mysqli_fetch_array($result)){
    $graphdata.= $row['CSNAME'] . " " . $row['MNAME']  . ",";
    $dec=$row['TCOUNT']/$total;
    $perc = round((float)$dec * 100,2) . '%';
    $graphdata.="$perc\n";
  }
  ?>

  <!-- Click Script -->
  <script type="text/javascript">
    function submitevent(tableRow) {
      //get ID
      var myID = tableRow.dataset.id;

      document.getElementById('event_id').value = myID;
      
      //submit
      var form = document.getElementById('event_more');
      form.submit();
    }; 
    function submitmember(tableRow) {
      //get ID
      var myID = tableRow.dataset.id;

      document.getElementById('member_id').value = myID;
      
      //submit
      var form = document.getElementById('member_more');
      form.submit();
    };    
  </script>

  <!-- Graph Script -->
  <script type="text/javascript">
    $(function () {

      Highcharts.data({
        csv: document.getElementById('csv').innerHTML,
        itemDelimiter: ',',
        parsed: function (columns) {

          var brands = {},
          brandsData = [],
          versions = {},
          drilldownSeries = [];

            // Parse percentage strings
            columns[1] = $.map(columns[1], function (value) {
              if (value.indexOf('%') === value.length - 1) {
                value = parseFloat(value);
              }
              return value;
            });

            $.each(columns[0], function (i, name) {
              var brand,
              version;

              if (i > 0) {

                    // Remove special edition notes
                    // name = name.split(' -')[0];

                    // Split into brand and version
                    brand = name.split(" ");
                    // version = name.match(/([0-9]+[\.0-9x]*)/);
                    // if (version) {
                      brand = brand[0];
                    // }
                    version = name.replace(brand, '');
                    // brand = name.replace(version, '');

                    // Create the main data
                    if (!brands[brand]) {
                      brands[brand] = columns[1][i];
                    } else {
                      brands[brand] += columns[1][i];
                    }

                    // Create the version data
                    if (version !== null) {
                      if (!versions[brand]) {
                        versions[brand] = [];
                      }
                        // versions[brand].push(['v' + version, columns[1][i]]);
                        versions[brand].push([version, columns[1][i]]);
                      }
                    }

                  });

            $.each(brands, function (name, y) {
              brandsData.push({ 
                name: name, 
                y: y,
                drilldown: versions[name] ? name : null
              });
            });
            $.each(versions, function (key, value) {
              drilldownSeries.push({
                name: key,
                id: key,
                data: value
              });
            });

            // Create the chart
            $('#graph').highcharts({
              chart: {
                type: 'column'
              },
              title: {
                text: 'Member Distribution'
              },
              subtitle: {
                text: 'Click the columns to view majors.'
              },
              xAxis: {
                type: 'category'
              },
              yAxis: {
                title: {
                  text: 'Total Percent'
                }
              },
              legend: {
                enabled: false
              },
              plotOptions: {
                series: {
                  borderWidth: 0,
                  dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                  }
                }
              },

              tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
              }, 

              series: [{
                name: 'Class Standing',
                colorByPoint: true,
                data: brandsData
              }],
              drilldown: {
                series: drilldownSeries
              }
            })

}
});
});


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
          <li class="active"><a href="portal.php">Dashboard</a></li>
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
          <li class="active"><a href="portal.php">Overview</a></li>
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
        <h1 class="page-header">Dashboard</h1>


        <div id="graph" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

        <!-- Data in CSV -->
        <pre id="csv" style="display:none">Member Distribution,Total Percentage
        <?php print $graphdata ?>
        </pre>

        <!-- Event Listing -->
        <h2 class="sub-header">Upcoming Events</h2>

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

        <!-- Member Listing -->
        <h2 class="form-heading">Member Listing</h2>

        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th><a href="?sortm=member_id">ID #</a></th>
                <th><a href="?sortm=username">Username</a></th>
                <th><a href="?sortm=first_name">First Name</a></th>
                <th><a href="?sortm=last_name">Last Name</a></th>
                <th><a href="?sortm=email">Email</a></th>
                <th><a href="?sortm=phone">Phone</a></th>
                <th><a href="?sortm=csname">Class Standing</a></th>
                <th><a href="?sortm=cname">Class</a></th>
                <th><a href="?sortm=rname">Rank</a></th>
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
  
  <form id='event_more' action="eventDetails.php" method="POST">
    <input type='hidden' id='event_id' name='event_id' value=''>
  </form>
  <form id='member_more' action="memberDetails.php" method="POST">
    <input type='hidden' id='member_id' name='member_id' value=''>
  </form>
</body>
</html>
