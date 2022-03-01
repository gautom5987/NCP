<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ncp";

    session_start();
    // get complain id
    $id = $_REQUEST['id'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $asignee = "";
    if(isset($_SESSION['asignee'])) {
        $asignee = $_SESSION['asignee'];
    }

    // variables for storing dynamic data from the user
    $markAs=$selectedTechnician=$adminComment="";
    $adminComment = " ";
    $newComment = "";
    $techComment = "";
    $_SESSION["name"] = $_POST["name"];
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["type"] = "update";
    $_SESSION["ticketId"] = $id;

    // updating values in the database
    $sql = "UPDATE ComplainData
    SET ";

    // storing data from the form
    if(isset($_POST['markAs'])) {
        $markAs = $_POST['markAs'];
        $sql = $sql . "isSolved=$markAs";
    }

    if(isset($_POST['selectedTechnician'])) {
        $selectedTechnician = $_POST['selectedTechnician'];
        $sql = $sql . ", asignee = $selectedTechnician";
    }

    if($_SESSION['purpose']=="admin" && isset($_POST['adminComment'])) {
        $adminComment = $_POST['adminComment'];
        $sql = $sql . ", adminComment = '$adminComment'";
    }

    if($_SESSION['purpose']=="tech" && isset($_POST["newComment"])) {
        $newComment = $_POST["newComment"];
        $techComment = $_POST["techComment"];
        date_default_timezone_set('Asia/Kolkata');
        $date = date('m/d/Y h:i:s a', time());
        $techComment = $techComment . "\n\n" . $date . " " . $asignee . "->\t" . $newComment;
        $sql = $sql . ", techComment = '$techComment'";
    }

    $sql = $sql . " WHERE id=$id";

    // Debug variable
    $flag = 0;

    if ($conn->query($sql) === TRUE) {
        $value= "Complain updated successfully.";
        $flag = 1;
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        $value = "Some error occured.\nPlease Try again.";
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

if($markAs==1) {
    echo "<script>if($flag==1){ window.open('mail.php','_blank') }</script>";
}

if($_SESSION['purpose']=='admin') {
//    echo "<script>if($flag==1){ location.replace('../pages/admin.php') }</script>";
//    echo "<script>if($flag==0){ location.replace('../pages/admin.php') }</script>";
    echo "<script>window.open('','_parent',''); window.close();</script>";
} else if($_SESSION['purpose']=='tech') {
//    echo "<script>if($flag==1){ location.replace('../pages/technician.php') }</script>";
//    echo "<script>if($flag==0){ location.replace('../pages/technician.php') }</script>";
    echo "<script>window.open('','_parent',''); window.close();</script>";
}

die();
?>
</body>
</html>
