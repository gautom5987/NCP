<?php
include "../verify/session.php";
$id = $_SESSION["id"];
$_SESSION['purpose'] = 'tech';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" href="../res/logo.png">
    <title>Network Complain Portal</title>
</head>
<body>
<div align="center">
    <img src="../res/mnnit.png" height="90" width="250">
</div>
<h1 align="center">Technician Dashboard</h1>
<br>
<br>

<form class="box">
    <a href="technicianIssues.php?id=<?php echo $id ?>">- Assigned issues</a><br><br>
    <a href="../verify/logout.php">- Log Out</a><br><br>
    <form>

</body>
</html>