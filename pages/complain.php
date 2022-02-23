<?php
    require_once "../res/strings.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" href="../res/logo.png">
    <title>Network Complain Portal</title>

    <script type="text/javascript" defer>
        function checkProblem(val) {
            var element = document.getElementById('problemInput');
            if (val == 'other')
                element.style.display = 'block';
            else
                element.style.display = 'none';
        }
    </script>
</head>

<body>
    <div align="center">
        <img src="../res/mnnit.png" height="90" width="250">
        <h1 id="login">Submit your complain here.</h1>
    </div>

    <br>

    <form method="POST" action="#" class="box">
        <p>Name :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" placeholder="name" name="name" required=true></p>

        <p>Email :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="email" placeholder="email id" name="email" required=true></p>

        <p>Mobile Number :&nbsp;&nbsp;&nbsp;<input type="text" placeholder="mobile number" name="mobile" required=true></p>

        <p>Location :&nbsp;&nbsp;&nbsp;&nbsp;
            <textarea id="location" name="location" rows="4" cols="50" required=true></textarea>
        </p>

        <p>Availability time :
            <input type="time" id="fromt" name="fromt" required=true/> -
            <input type="time" id="till" name="till" required=true/>
        </p>

        <p>Problem :&nbsp;&nbsp;&nbsp;
            <select id="problem" name="problemName" onchange="checkProblem(this.value);">
                <option value="lanp">LAN problem</option>
                <option value="wifip">WI-FI problem</option>
                <option value="ipaddr">IP address issue</option>
                <option value="proxy">Proxy issue</option>
                <option value="lanBr">LAN port broken</option>
                <option value="wifiSignal">Wifi Signal issue</option>
                <option value="newRouter">New Wifi Router installation</option>
                <option value="boot">System not booting</option>
                <option value="noDisplay">No Display</option>
                <option value="os">OS reinstallation</option>
                <option value="noPower">System not powering on</option>
                <option value="other">other</option>
            </select>
        </p>

        <p id="problemInput" style='display:none;'>Describe your problem :&nbsp;&nbsp;&nbsp;&nbsp;
            <textarea name="problemDes" rows="4" cols="50"></textarea>
        </p>

        <p>Enter OTP :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" placeholder="otp" name="otp"></p>
        <br>

        <input type="submit" value="Send OTP" id="submit" formaction="../verify/sendEmailOtp.php" formtarget="_blank">
        <input type="submit" value="   Submit   " id="submit" formaction="../verify/complainSubmit.php" title="OTP will be sent to your mobile">
    </form>

</body>

</html>