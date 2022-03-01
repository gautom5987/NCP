<?php
    include "../verify/session.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <link rel="icon" href="../res/logo.png">
    <title>Network Complaint Portal</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="../css/signin.css" rel="stylesheet">
</head>
<body class="text-center">

<main class="form-signin">
    <form method="POST" action="../verify/signupSubmit.php">
        <img class="mb-5" src="../res/mnnit.png" alt="" width="260" height="100">
        <h1 class="h3 mb-3 fw-normal">Add a Technician</h1>
        <br>
        <div class="form-floating">
            <input type="text" class="form-control" id="floatingInput" placeholder="name" name="name" required>
            <label for="floatingInput">Name</label>
        </div><br>
        <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" required>
            <label for="floatingInput">Email address</label>
        </div><br>
        <div class="form-floating">
            <input type="number" class="form-control" id="floatingInput" placeholder="number" name="mobile" required>
            <label for="floatingInput">Mobile No.</label>
        </div><br>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
            <label for="floatingPassword">Password</label>
        </div><br>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2022 Computer Centre MNNIT</p>
    </form>
</main>

</body>
</html>
