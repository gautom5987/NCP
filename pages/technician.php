<?php
include "../verify/session.php";

$id = 0;

if(isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];
} else {
    $id = $_SESSION["id"];
}

if(!isset($_SESSION['purpose'])) {
    $_SESSION['purpose'] = 'tech';
}
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ncp";

// Create connection
$conn = new mysqli($servername, $username, $password);

if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION["type"])) {
    $_SESSION["type"] = "all";
}

$tid = $id;

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

// fetching data
$sql = "SELECT * FROM ComplainData WHERE asignee='$tid' ";

if($_SESSION["type"]=="solved") {
    $sql .= "AND isSolved='1' ";
}
else if($_SESSION["type"]=="unsolved"){
    $sql .= "AND isSolved='0' ";
}

$result = $conn->query($sql);
$table = "";

while($row = $result-> fetch_array(MYSQLI_ASSOC) ){   //Creates a loop to loop through results
    $table .= "<tr><td><a target='_blank' href='displayComplain.php?id=".$row['id']."'>" . $row['id'] . "</a></td><td>" . $row['uname'] . "</td><td>" . $row['reg_date'] . "</td><td>";

    if($row['isSolved']==0)
        $table .= "Not solved" . "</td></tr>";
    else
        $table .= "Solved" . "</td></tr>";
}

$sortType = "";

//session_abort();
$conn->close();
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
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Technician Panel - Network Complaint Portal</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!--  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">-->
    <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <a class="nav-link px-3" href="../verify/logout.php" <?php if($_SESSION['purpose']!='tech') echo 'style="display: none"'; ?> >Sign out</a>
        </div>
    </div>
</header>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">
                            <span data-feather="home"></span>
                            All Complaints
                        </a>
                    </li>
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
                        <th scope="col">ID</th>
                        <th scope="col">Issued by</th>
                        <th scope="col">Issue Date</th>
                        <th scope="col">Status</th>
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
