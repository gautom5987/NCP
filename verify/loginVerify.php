<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ncp";

require '../credentials.php';

// Create connection
$conn = new mysqli($servername, $username, $password);

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

session_start();
$_SESSION["auth"] = "invalid";
$_SESSION["email"]=$_SESSION["password"]=$_SESSION["loginAs"]="";
$_SESSION["id"]="";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    // variables for storing dynamic data from the user
    $email=$password=$loginAs=$value=$location="";
    $flag=0;

    // storing data from the form
    $email=$_POST['email'];
    $password=$_POST['password'];
    $loginAs=$_POST['loginAs'];

    if($loginAs=="admin") {
        if($email==$adminUsername && $password==$adminPassword) {
            $flag = 1;
            $value = "Moving to admin panel";
            $location = "../pages/admin.php";
            // setting session variables
            $_SESSION["auth"] = "valid";
        }
        else {
            $flag = 0;
            $value = "Wrong credentials";
            $_SESSION["auth"] = "invalid";
        }
    }
    else {
        $sql = "SELECT * FROM TechnicianData WHERE email='$email' AND password='$password' ";
        $result = $conn->query($sql);

        if($result==null) {
            echo "<script>alert('No Technician registered!')</script>";
            echo "<script>location.replace('../index.php');</script>";
        }

        if($data = $result->fetch_assoc()) {
            $_SESSION["id"] = $data['id'];
            $value = "Welcome " . $data['uname'];
            $flag = 1;
            $location = "../pages/technician.php";
            $_SESSION["auth"] = "valid";
        }
        else {
            $value = "Wrong credentials";
            $flag = 0;
            $_SESSION["auth"] = "invalid";
        }
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>page</title>
</head>
<body>
  <?php

    echo "<script>alert('$value')</script>";
    echo "<script>if($flag==1){ location.replace('$location') }</script>";
    echo "<script>if($flag==0){ location.replace('../pages/login.php') }</script>";
  ?>
</body>
</html>