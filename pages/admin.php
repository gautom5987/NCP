<?php
    include "../verify/session.php";
    $_SESSION['purpose'] = 'admin';
?>

<!DOCTYPE html>
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
    <h1>Admin Panel</h1>
</div>
<br>
<br>

<form class="box">
    <a href="complainList.php?id=normal">- View Complains</a><br><br>
    <a href="complainList.php?id=daily">- Daily Reports</a><br><br>
    <a href="complainList.php?id=weekly">- Weekly Reports</a><br><br>
    <a href="complainList.php?id=monthly">- Monthly Reports</a><br><br>
    <a href="complainList.php?id=yearly">- Yearly Reports</a><br><br>
    <a href="technicianList.php">- View Technician List</a><br><br>
    <a href="../verify/logout.php">- Log Out</a>
<form>

</body>
