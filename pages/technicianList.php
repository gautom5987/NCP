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
$sql = "SELECT * FROM TechnicianData ";

$result = $conn->query($sql);
$table = "";

if($result==null) {
    echo "<script>alert('No Technicians registered!')</script>";
    echo "<script>location.replace('admin.php');</script>";
}

while($row = $result-> fetch_array(MYSQLI_ASSOC) ){   //Creates a loop to loop through results
    $table .= "<tr><td><a href='technicianIssues.php?id=".$row['id']."'>" . $row['id'] . "</a></td><td>" . $row['uname'] . "</td><td>" . $row['mobile'] . "</td><td>";
    $table .= $row['email'] . "</td></tr>";
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
<h2 align="center">Technician Table</h2>
<p align="center">(Click on id to view issues assigned)</p>

<br>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Mobile No.</th>
        <th>Email ID</th>
    </tr>
    <?php
    echo $table;
    ?>
</table>

</body>
</html>

