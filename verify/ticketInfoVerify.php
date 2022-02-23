<?php
session_start();

$_SESSION['purpose'] = 'ticket';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ncp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// fetch data from form
$ticketId = $_POST['id'];

// SQL query for fetching user data
$sql = "SELECT * FROM complainData WHERE id='$ticketId' ";

$result = $conn->query($sql);

if($result==null) {
    echo "<script>alert('No Complains registered yet!')</script>";
    echo "<script>location.replace('../index.php');</script>";
}

$flag=0;

if($data= $result->fetch_assoc()) 
{
    $flag=1;
    $value= "Hello, " . $data['uname'] . ". ";
    if($data['isSolved']==0) 
        $value = $value . "Your issue has not been solved yet.";
    else
        $value = $value . "Your issue has been solved.";
}

else 
{
    $value= "Invalid ticket number!";
    $flag=0;
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
    echo "<script>if($flag==1){ location.replace('../pages/displayComplain.php?id='+'$ticketId') }</script>";
    echo "<script>if($flag==0){ location.replace('../pages/ticketInfo.php') }</script>";
  ?>
</body>
</html>