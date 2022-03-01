<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, intial-scale=1.0">
    <title>Network Complaint Portal</title>
    <link rel="stylesheet" href="css/style-index.css"/>
    <link rel="stylesheet" href="css/style-index-2.css"/>
    <link rel="shortcut icon" href="res/logo.png"/>

</head>

<body>

<section class="main" style="background-image: url(res/hero-bg.png);">

    <nav>
        <a href="http://www.mnnit.ac.in/" class="logo">
            <img src="res/mnnit.png" width="250px" />
        </a>
        <input class="menu-btn" type="checkbox" id="menu-btn"/>
        <label class="menu-icon" for="menu-btn">
            <span class="nav-icon"></span>
        </label>
        <ul class="menu" style="border-radius: 5px;">
            <li><a href="pages/complain.php">Submit Complaint</a></li>
            <li><a href="pages/ticketInfo.php">Complaint Status</a></li>
            <li><a href="pages/login.php" class="active" style="width:auto; border-radius: 5px; cursor: pointer;">CC Admins</a></li>
        </ul>
    </nav>

    <!--main-content-->
    <div class="home-content">

        <!--text-->
        <div class="home-text" >

            <h3 style="color: white; letter-spacing: 3px;">Welcome to MNNIT</h3>
            <h1 style="color: white;"> Network Complaint Portal</h1>
            <p style="color: white;">This is the official site for network complaint MNNIT.</p>
            <a href="pages/complain.php" class="main-login" style="border-radius: 5px;">Submit a Complaint</a>
        </div>
    </div>
</section>

<!--footer------------->
<footer>
    <p>Copyright (C) - 2022 | Developed By <a href="http://mnnit.ac.in/computercentre/">Computer Centre MNNIT</a> </p>
</footer>

</body>

</html>
