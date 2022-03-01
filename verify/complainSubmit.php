<?php
    $backendOtp = "";

    session_start();
    if(isset($_SESSION["backendOtp"])) {
        $backendOtp = $_SESSION["backendOtp"];
    }
    if($backendOtp!=$_POST['otp']) {
        echo "<script>alert('Entered OTP is wrong ');</script>";
        echo "<script>location.replace('../pages/complain.php')</script>";
        exit();
    }
?>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ncp";

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

    // Now since our DB is created, building new connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // sql to create table
    $sql = "CREATE TABLE ComplainData (
            id VARCHAR (12) PRIMARY KEY,
            uname VARCHAR(50) NOT NULL,
            mobile VARCHAR(50) NOT NULL,
            email VARCHAR(50) NOT NULL,
            ulocation VARCHAR(1000) NOT NULL,
            problemName VARCHAR(1000) NOT NULL,
            problemDes VARCHAR(1000),
            isSolved VARCHAR(1) NOT NULL,
            asignee VARCHAR(50),
            remark VARCHAR(1000),
            fromt TIME,
            till TIME,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            adminComment VARCHAR(1000),
            techComment VARCHAR(1000)
            )";

    if ($conn->query($sql) === TRUE) {
        // echo "Table ComplainData created successfully";
    } else {
        // echo "Error creating table: " . $conn->error;
    }

    // variables for storing dynamic data from the user
    $uname=$mobile=$email=$ulocation=$problemName=$problemDes=$from=$till=$adminComment=$techComment="";

    // storing data from the form
    $uname = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $ulocation = $_POST['location'];
    $problemName = $_POST['problemName'];
    $problemDes = $_POST['problemDes'];
    $fromt = $_POST['fromt'];
    $till = $_POST['till'];

    $last_id = time().rand(10,99);

    // Inserting data in table
    $sql = "INSERT INTO ComplainData (id, uname, mobile, email, ulocation, problemName, problemDes, isSolved, fromt, till, adminComment, techComment)
    VALUES ('$last_id', '$uname', '$mobile', '$email', '$ulocation', '$problemName', '$problemDes', '0', '$fromt', '$till', '$adminComment', '$techComment')";

    # Debug Message
    $flag = 0;
    $value = '';
    if ($conn->query($sql) === TRUE) {
//        $last_id = $conn -> insert_id;
        $value= "Complaint submission successful. Ticket number -> " . $last_id;
        $_SESSION["ticketId"] = $last_id;
        $_SESSION["type"] = "id";
        $_SESSION["email"] = $email;
        $_SESSION["name"] = $uname;
        $flag = 1;
    } 
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        $flag = 0;
        $value = 'Failed to submit your complain!';
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
    echo "<script>if($flag==1){ window.open('mail.php','_blank') }</script>";
    echo "<script>if($flag==1){ location.replace('../index.php') }</script>";
    echo "<script>if($flag==0){ location.replace('../pages/complain.php') }</script>";
  ?>
</body>
</html>