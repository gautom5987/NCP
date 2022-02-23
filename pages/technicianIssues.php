<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ncp";

include "../verify/session.php";

// Create connection
$conn = new mysqli($servername, $username, $password);

if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION["type"])) {
    $_SESSION["type"] = "all";
}

$tid = $_REQUEST["id"];

//try {
//    if($_SESSION["type"]==null)
//        $_SESSION["type"] = "all";
//} catch (Exception $e) {
//    // nothing to do with it
//    $_SESSION["type"] = "all";
//}

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
    $table .= "<tr><td><a href='displayComplain.php?id=".$row['id']."'>" . $row['id'] . "</a></td><td>" . $row['uname'] . "</td><td>" . $row['reg_date'] . "</td><td>";

    if($row['isSolved']==0)
        $table .= "Not solved" . "</td></tr>";
    else
        $table .= "Solved" . "</td></tr>";
}

$sortType = "";

session_abort();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" href="../res/logo.png">
    <title>Network Complain Portal</title>

    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
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

</head>
<body>
<div align="center">
    <img src="../res/mnnit.png" height="90" width="250">
</div>
<h2 align="center">Complain Table</h2>
<p align="center">(Click on id to view or update details)</p>

<div align="center">
    <p>Filter :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio"name="filter" value="solved" onclick="handleClick(this.value);"
            <?php
            if($_SESSION["type"]=='solved')
                echo "checked";
            ?>
        >
        <label for="admin">Solved</label>

        <input type="radio" name="filter" value="unsolved" onclick="handleClick(this.value);"
            <?php
            if($_SESSION["type"]=='unsolved')
                echo "checked";
            ?>
        >
        <label for="unsolved">Unsolved</label>

        <input type="radio" name="filter" value="all" onclick="handleClick(this.value);"
            <?php
            if($_SESSION["type"]=='all')
                echo "checked";
            ?>
        >
        <label for="all">all</label>
    </p>

</div>

<br>

<table>
    <tr>
        <th>ID</th>
        <th>Issued by</th>
        <th>Issue Date</th>
        <th>Status</th>
    </tr>
    <?php
    echo $table;
    ?>
</table>

</body>
</html>

