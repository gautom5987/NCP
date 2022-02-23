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
// currentIssueId = -1 indicates that a technician is not working anywhere
$sql = "CREATE TABLE TechnicianData (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            uname VARCHAR(50) NOT NULL,
            mobile VARCHAR(50) NOT NULL,
            email VARCHAR(50) NOT NULL,
            password VARCHAR(50) NOT NULL,
            currentIssueId INT DEFAULT -1,
            IssuesSolved INT DEFAULT 0,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";

if ($conn->query($sql) === TRUE) {
    // echo "Table ComplainData created successfully";
} else {
    // echo "Error creating table: " . $conn->error;
}

// variables for storing dynamic data from the user
$uname=$mobile=$email=$pass="";

// storing data from the form
$uname = $_POST['name'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];
$pass = $_POST['password'];

$sql = "SELECT * from TechnicianData WHERE email='$email'";
$result = $conn->query($sql);

if($result->fetch_assoc()) {
    $value = "Email id is already registered !";
    $flag=0;
}
else {
// Inserting data in table
    $sql = "INSERT INTO TechnicianData (uname, mobile, email, password)
    VALUES ('$uname', '$mobile', '$email', '$pass')";

# Debug Message
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        $value = "User created successfully. User id -> " . $last_id;
        $flag = 1;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
echo "<script>if($flag==1){ location.replace('../index.php') }</script>";
echo "<script>if($flag==0){ location.replace('../pages/signup.php') }</script>";
?>
</body>
</html>