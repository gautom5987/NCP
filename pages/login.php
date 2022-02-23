<!DOCTYPE html>
<html>
    <head>
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="icon" href="../res/logo.png">
        <title>Network Complain Portal</title>
    </head>

    <body>
        <div align="center">
            <img src="../res/mnnit.png" height="90" width="250">
        </div>
        <h1 id="login">Login Page</h1>

        <br>
        
        <form method="POST" action="../verify/loginVerify.php" class="box">
            <p>email :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="email" placeholder="email" name="email" required></p>

            <p>password :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="password" placeholder="password" name="password" required></p>
            
            <p>Login as :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" id="admin" name="loginAs" value="admin" required>
                <label for="admin">Admin</label>
                <input type="radio" id="tech" name="loginAs" value="tech" required>
                <label for="tech">Technician</label><br>
            </p>
            <br>

            <input type="submit" value="    login   " id="submit">
            
            

        </form>

    </body>
</html>