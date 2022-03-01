<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ncp";

include "../verify/session.php";
$_SESSION['purpose'] = 'admin';

$active = 'class="nav-link active"';
$inactive = 'class="nav-link"';

// Create connection
$conn = new mysqli($servername, $username, $password);

if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_REQUEST["id"])) {
    $_REQUEST["id"] = "normal";
}

if(!isset($_SESSION["type"])) {
    $_SESSION["type"] = "all";
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE ncp";
if ($conn->query($sql) === TRUE) {
    // echo "Database created successfully";
} else {
    // echo "Error creating database: " . $conn->error;
}

$conn->close();

// Now since our DB is created, building new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// variables for storing dynamic data from the user
$uname=$mobile=$email=$ulocation=$problemName=$problemDes="";

if(!isset($_REQUEST["purpose"])) {
// fetching data
    $sql = "SELECT * FROM ComplainData ";

    if ($_SESSION["type"] == "solved") {
        $sql .= "WHERE isSolved='1' ";
    } else if ($_SESSION["type"] == "unsolved") {
        $sql .= "WHERE isSolved='0' ";
    }

    if ($_SESSION["type"] != "all" && $_REQUEST["id"] != "normal") {
        $sql .= "AND ";
    }
    if ($_SESSION["type"] == "all" && $_REQUEST["id"] != "normal") {
        $sql .= "WHERE ";
    }

    if ($_REQUEST["id"] === "daily") {
        $sql .= "DATE(reg_date)=CURDATE()";
    } else if ($_REQUEST["id"] === "weekly") {
        $sql .= "WEEK(reg_date)=WEEK(CURTIME())";
    } else if ($_REQUEST["id"] === "monthly") {
        $sql .= "MONTH(reg_date)=MONTH(CURTIME())";
    } else if ($_REQUEST["id"] === "yearly") {
        $sql .= "YEAR(reg_date)=YEAR(CURTIME())";
    }

    $result = $conn->query($sql);
    $table = "";

    $flag = 1;

    if ($result == null) {
        $flag = 0;
//        echo "<script>alert('No Complains registered!')</script>";
//        echo "<script>location.replace('admin.php');</script>";
    }

    $col_1 = "ID";
    $col_2 = "Issued by";
    $col_3 = "Issue Date";
    $col_4 = "Status";

    while ($flag && $row = $result->fetch_array(MYSQLI_ASSOC)) {   //Creates a loop to loop through results
        $table .= "<tr><td><a target='_blank' href='displayComplain.php?id=" . $row['id'] . "'>" . $row['id'] . "</a></td><td>" . $row['uname'] . "</td><td>" . $row['reg_date'] . "</td><td>";

        if ($row['isSolved'] == 0)
            $table .= "Not solved" . "</td></tr>";
        else
            $table .= "Solved" . "</td></tr>";
    }

    $sortType = "";
    $conn->close();
} else if($_REQUEST["purpose"]==="tech") {
    // fetching data
    $sql = "SELECT * FROM TechnicianData ";

    $result = $conn->query($sql);
    $table = "";

    if($result==null) {
        echo "<script>alert('No Technicians registered!')</script>";
        echo "<script>location.replace('admin.php');</script>";
    }

    $col_1 = "ID";
    $col_2 = "Name";
    $col_3 = "Mobile No.";
    $col_4 = "Email ID";

    while($row = $result-> fetch_array(MYSQLI_ASSOC) ){   //Creates a loop to loop through results
        $table .= "<tr><td><a target='_blank' href='technician.php?id=".$row['id']."'>" . $row['id'] . "</a></td><td>" . $row['uname'] . "</td><td>" . $row['mobile'] . "</td><td>";
        $table .= $row['email'] . "</td></tr>";
    }

    $sortType = "";

//    session_abort();
    $conn->close();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
      <title>Network Complaint Portal</title>
      <link rel="icon" href="../res/logo.png">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">

    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

      <script>
          function handleClick(type) {
              var xmlHttp = new XMLHttpRequest();
              xmlHttp.open("GET", "updateType.php?type=" + type,true);
              xmlHttp.send();
              location.reload();
          }
      </script>
    
    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Admin Panel - Network Complain Portal</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
<!--  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">-->
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="../verify/logout.php">Sign out</a>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a <?php if($_REQUEST["id"]==="normal" && !isset($_REQUEST["purpose"])) echo $active; else echo $inactive; ?> aria-current="page" href="?id=normal">
              <span data-feather="home"></span>
              All Complaints
            </a>
          </li>

          <li class="nav-item">
            <a <?php if(isset($_REQUEST["purpose"]) && $_REQUEST["purpose"]==="tech") echo $active; else echo $inactive; ?> href="?purpose=tech">
              <span data-feather="users"></span>
              Technicians
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="signup.php" target="_blank">
              <span data-feather="plus-circle"></span>
              Add a Technician
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Saved reports</span>
<!--          <a class="link-secondary" href="#" aria-label="Add a new report">-->
<!--            <span data-feather="plus-circle"></span>-->
<!--          </a>-->
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a <?php if($_REQUEST["id"]==="daily") echo $active; else echo $inactive; ?> href="?id=daily">
              <span data-feather="file-text"></span>
              Current Day
            </a>
          </li>
          <li class="nav-item">
            <a <?php if($_REQUEST["id"]==="weekly") echo $active; else echo $inactive; ?> href="?id=weekly">
              <span data-feather="file-text"></span>
              Current Week
            </a>
          </li>
          <li class="nav-item">
            <a <?php if($_REQUEST["id"]==="monthly") echo $active; else echo $inactive; ?> href="?id=monthly">
              <span data-feather="file-text"></span>
              Current Month
            </a>
          </li>
          <li class="nav-item">
            <a <?php if($_REQUEST["id"]==="yearly") echo $active; else echo $inactive; ?> href="?id=yearly">
              <span data-feather="file-text"></span>
              Current Year
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
            <select onchange="handleClick(this.value);" <?php if(isset($_REQUEST["purpose"])) echo 'style="display: none"'; ?> >
                <option value="all" <?php if($_SESSION["type"]=='all') echo "selected"; ?>>All</option>
                <option value="solved" <?php if($_SESSION["type"]=='solved') echo "selected"; ?>>Solved</option>
                <option value="unsolved" <?php if($_SESSION["type"]=='unsolved') echo "selected"; ?>>Unsolved</option>
            </select>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col"><?php echo $col_1 ?></th>
              <th scope="col"><?php echo $col_2 ?></th>
              <th scope="col"><?php echo $col_3 ?></th>
              <th scope="col"><?php echo $col_4 ?></th>
            </tr>
          </thead>
          <tbody>
          <?php
            echo $table;
          ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>

    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
        <script src="../assets/dashboard.js"></script>
  </body>
</html>
